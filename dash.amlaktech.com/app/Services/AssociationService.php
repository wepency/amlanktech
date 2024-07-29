<?php

namespace App\Services;

use App\Http\Requests\StoreManagerRequest;
use App\Interfaces\AssociationInterface;
use App\Models\Admin;
use App\Models\Association;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssociationService implements AssociationInterface
{

    public static function CreateOrUpdate(Request $request, Association $association)
    {
        DB::beginTransaction();

        $fields = $request->only((new Association)->getFillable());
        $dataAssociation = [];

        foreach ($fields as $key => $field) {
            if ($field == '')
                unset($fields[$key]);

            // Upload certificate if exists
            $dataAssociation['registration_certificate'] = self::uploadCertificate($request, $key);
        }

        $association = $association->updateOrCreate([
            'id' => $association?->id
        ], array_merge($fields, $dataAssociation));


        self::associateAdmin($association?->id);

        DB::commit();

//        Admin::findOrFail($request->admin_id)->update([
//            'association_id' => $association->id
//        ]);
    }

    private static function uploadCertificate(Request $request, $key)
    {
        $fileName = null;

        if ($request->hasFile('registration_certificate') && $key == 'registration_certificate') {
            $file = $request->file('registration_certificate');
            $fileName =  $file->getClientOriginalName().'-'.time().'.'.strtolower($file->getClientOriginalExtension());
            $file->move('uploads', $fileName);
        }

        return $fileName;
    }

    private static function associateAdmin($associationId)
    {
        if (isset($request->admin_id)) {
            self::assignAssociationIdToAdmin($associationId);
        }else {
            self::createNewAdmin($associationId);
        }
    }

    private static function assignAssociationIdToAdmin($associationId)
    {
        Admin::where('association_id', $associationId)->get()->each(function ($admin) {
            $admin->update([
                'association_id' => null
            ]);
        });

        Admin::findOrFail(request()->admin_id)->update([
            'association_id' => $associationId
        ]);
    }

    private static function createNewAdmin($associationId)
    {
        if (\request()->manager_name && \request()->email && \request()->password) {

            request()->merge([
                'name' => request()->manager_name,
                'association_id' => $associationId
            ]);

            if(request()->validate((new StoreManagerRequest)->rules()))
            {
                AdminService::createOrUpdate(request(), new Admin);
            }
        }
    }
}

<?php

namespace App\Services;

use App\Http\Requests\StoreManagerRequest;
use App\Interfaces\AssociationInterface;
use App\Models\Admin;
use App\Models\Association;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AssociationService implements AssociationInterface
{

    public static function CreateOrUpdate(Request $request, Association $association)
    {

        DB::beginTransaction();

        $fields = $request->only((new Association)->getFillable());
        $dataAssociation = [];

        foreach ($fields as $key => $field) {
//            if ($field == '' || $key == 'registration_certificate')
//                unset($fields[$key]);
        }

        // Upload certificate if exists
//        $dataAssociation['registration_certificate'] = self::uploadCertificate($request);
        $dataAssociation['admin_id'] = $request->admin_id;

        $association = $association->updateOrCreate([
            'id' => $association?->id
        ], array_merge($fields, $dataAssociation));

        self::associateAdmin($association?->id);

        Log::debug($association->id);

        DB::commit();

//        Admin::findOrFail($request->admin_id)->update([
//            'association_id' => $association->id
//        ]);
    }

    private static function uploadCertificate(Request $request)
    {
        $fileName = null;

        if ($request->hasFile('registration_certificate')) {
            $file = $request->file('registration_certificate');
            $fileName = $file->getClientOriginalName().'-'.time().'.'.strtolower($file->getClientOriginalExtension());
            $file->move(public_path('uploads'), $fileName);
            return $fileName;
        }

        return $fileName;
    }

    private static function associateAdmin($associationId)
    {
//        if (isset($request->admin_id)) {
//            self::assignAssociationIdToAdmin($associationId);
//        }else {
//            self::createNewAdmin($associationId);
//        }
        $admin = Admin::withTrashed()->findOrFail(request()->admin_id);

        $admin->restore();

        $admin->syncRoles([7]);

        return $admin->update([
           'association_id' => $associationId
        ]);
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

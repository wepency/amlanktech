<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Association;
use Illuminate\Http\Request;

class AssociationController extends Controller
{
    public function feeTypeForm(Association $association)
    {
        return response()->json([
            'data' => view('Admin.Associations.fee_type', [
                'association' => $association
            ])->render()
        ]);
    }

    public function getAssociations(Request $request, Association $association)
    {
        if ($request->filled('q')) {
            $association = $association->where('name', 'like', '%' . $request->q . '%');
        }

        $association = Association::get('name', 'id')->map(function ($item) {
            return [
                'id' => $item['id'],
                'text' => $item['name']
            ];
        });

        return response()->json([
            'data' => $association
        ]);
    }

    public function getAssociationFeesLabel(Association $association)
    {
        return response()->json([
            'text' => trans('labels.association_fee_label', ['label' => $association->feeType->label, 'identifier' => $association->feeType->identifier])
        ]);
    }
}

<?php

namespace App\Http\Actions\Policy;

use App\Models\Policy;
use Illuminate\Http\Request;

class StorePolicyHandler
{
    public function __construct(
        public Request $request
    ){}

    public function handle(): Policy
    {
        $association_id = $this->request->get('association_id');

        if (!is_admin()) {
            $association_id = get_admin_id();
        }

        $policy = new Policy;
        $policy->name= $this->request->get('name');
        $policy->association_id = $association_id;

        $policy->status = $this->request->status == 'on';
        $policy->notes = $this->request->notes;

        if ($this->request->hasFile('policy_file')) {
            $file = $this->request->file('policy_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/policies', $fileName);
            $policy->policy_file = 'policies/' . $fileName;
        }

        $policy->save();

        return $policy;
    }
}

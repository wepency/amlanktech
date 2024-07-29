<?php

namespace App\Http\Actions\Policy;

use App\Models\Policy;
use Illuminate\Http\Request;

class UpdatePolicyHandler
{
    public string $message;

    public function __construct(
        public Request $request,
        public Policy $policy,
    )
    {
    }

    public function handle(): self
    {
        $association_id = $this->request->get('association_id');

        if (!is_admin()) {
            $association_id = get_admin_id();
        }

        $this->policy->name= $this->request->get('name');

        $this->policy->association_id = $association_id;

        $this->policy->status = $this->request->status == 'on';
        $this->policy->notes = $this->request->notes;

        if ($this->request->hasFile('policy_file')) {
            $file = $this->request->file('policy_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/policies', $fileName);
            $this->policy->policy_file = 'policies/' . $fileName;
        }

        $this->policy->save();

        $this->message = 'The User Has Been Updated Successfully';

        return $this;
    }

}

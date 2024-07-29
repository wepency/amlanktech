<?php

namespace App\Http\Actions\Meeting;

use App\Models\Meeting;
use Illuminate\Http\Request;

class UpdateMeetingHandler
{
    public string $message;

    public function __construct(
        public Request $request,
        public Meeting $meeting,
    )
    {
    }

    public function handle(): self
    {


        if (is_manager()) {
            $this->meeting->association_id = auth()->user()->association_id;
        }else {
            $this->meeting->association_id = $this->request->get('association_id');
        }

        $this->meeting->title= $this->request->get('title');
        $this->meeting->status= $this->request->get('status');
        $this->meeting->date= $this->request->get('date');
        $this->meeting->start_time = $this->request->get('start_time');
        $this->meeting->end_time = $this->request->get('end_time');

        $this->meeting->min_users = $this->request->min_users;
        $this->meeting->users_type = $this->request->users_type;

        $this->meeting->save();

        $this->message = 'The Meeting Has Been Updated Successfully';

        return $this;
    }

}

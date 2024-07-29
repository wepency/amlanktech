<?php

namespace App\Http\Actions\Meeting;

use App\Models\Meeting;
use Illuminate\Http\Request;

class StoreMeetingHandler
{
    public function __construct(
        public Request $request
    ){}

    public function handle(): Meeting
    {
        $meeting = new Meeting;

        $meeting->association_id = $this->request->association_id ?? getAssociationId();

        $meeting->title= $this->request->get('title');

        $meeting->date= $this->request->get('date');
        $meeting->start_time = $this->request->get('start_time');
//        $meeting->end_time = $this->request->get('end_time');

        $meeting->min_users = $this->request->min_users;
        $meeting->users_type = $this->request->users_type;

        $meeting->meeting_id= $this->request->meeting_id;
        $meeting->passcode= $this->request->passcode;

        $meeting->save();

        return $meeting;
    }
}

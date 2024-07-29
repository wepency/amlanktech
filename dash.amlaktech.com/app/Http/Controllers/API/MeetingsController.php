<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\MeetingsResource;
use App\Models\Meeting;
use App\Traits\generateAPI;
use Illuminate\Http\Request;

class MeetingsController extends Controller
{
    use generateAPI;

    public function index(Request $request)
    {
        $meetings = Meeting::orderBy('id', 'DESC')->paginate();

        return $this->success([
                'meetings' => MeetingsResource::collection($meetings)
            ] + $this->pagination_links($meetings));
    }

    public function show(Meeting $meeting)
    {
        return $this->success(['meeting' => MeetingsResource::make($meeting)]);
    }

    public function canJoin(Meeting $meeting)
    {
        return $this->success([
            'min_users' => $meeting->min_users,
            'current_users' => 5,
            'can-join' => false
        ]);
    }
}

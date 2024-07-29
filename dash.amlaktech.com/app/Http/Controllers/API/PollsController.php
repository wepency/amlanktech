<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\PollsResource;
use App\Models\Poll;
use App\Models\PollVote;
use App\Models\User;
use App\Traits\generateAPI;
use Illuminate\Http\Request;

class PollsController extends Controller
{
    use generateAPI;

    public function index(Request $request, Poll $polls)
    {
        if ($request->association_id) {
            $polls->where('association_id', $request->association_id);
        }

        $polls = $polls->with('items', 'votes', 'items.votes')->withCount('votes')->withCount(['items' => function ($query) {
            return $query->withCount('votes');
        }])->orderBy('id', 'DESC')->get();

        return $this->success([
            'polls' => PollsResource::collection($polls)
        ]);
    }

    public function show(Poll $poll)
    {
        return $this->success([
            'poll' => new PollsResource($poll)
        ]);
    }

    public function toggleVote(Request $request, Poll $poll)
    {
        $request->validate([
            'option_id' => 'required|exists:poll_items,id'
        ]);

        $model = User::class;

        if(PollVote::updateOrCreate([
            'poll_id' => $poll->id,
            'user_id' => get_auth()->id(),
            'user_model' => $model
        ], [
            'poll_item_id' => $request->option_id,
            'poll_id' => $poll->id,
            'user_id' => get_auth()->id(),
            'user_model' => $model
        ])) {
            return $this->success([
                'message' => 'تم التصويت بنجاح.',
                'poll' => PollsResource::make($poll)
            ]);
        }
    }

    public function destroy(Poll $poll)
    {
        if ($poll->delete())
            return $this->success(['تم حذف التصويت بنجاح.']);

        return $this->error(['هناك مشكلة في حذف التصويت برجاء المحاولة لاحقا.']);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Option;
use App\Models\PaymentReceipt;
use App\Models\Poll;
use App\Services\PollService;
use App\Services\ReceiptService;
use Illuminate\Http\Request;

class PollController extends Controller
{

    public function index(Request $request)
    {
        $polls = Poll::with('items', 'votes');

        $page_title = trans('labels.polls');

        if (!is_admin()) {
            $polls->whereAssociationId(getAssociationId());
        }

        if ($request->ajax()) {

            return (new PollService($polls))
                ->editCreatedAtColumn()
                ->editColumnId()
                ->editColumnId()
                ->getAssociationDetails()
                ->addColumnCreatedBy()
                ->addColumnItems()
                ->addColumnVotes()
                ->addColumnActions()
                ->rawTableColumns()
                ->setRowId()
                ->toJson();

        }

        return view('Admin.Polls.Index', [
            'page_title' => $page_title,
            'polls' => $polls,
            'singleModel' => ReceiptService::SINGLE_MODEL_TITLE,
            'pluralModel' => ReceiptService::PLURAL_MODEL_TITLE,
        ]);
    }


    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'options.*' => 'required|string|max:255',
        ]);


        $poll = Poll::create([
            'name' => $request->input('name'),
        ]);


        foreach ($request->input('options') as $option) {
            Option::create([
                'poll_id' => $poll->id,
                'option' => $option,
            ]);
        }

        return redirect()->route('dashboard.polls.index')
            ->with('success', 'Poll created successfully.');
    }

    public function update(Request $request, $id)
    {
        $poll = Poll::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'options.*' => 'required|string|max:255',
        ]);

        $poll->update([
            'name' => $validatedData['name'],
        ]);

        $poll->options()->delete();
        foreach ($validatedData['options'] as $option) {
            $poll->options()->create(['option' => $option]);
        }

        return redirect()->route('dashboard.polls.index')->with('success', 'Poll updated successfully');
    }

    public function show($id)
    {
        $poll = Poll::findOrFail($id);

        return view('Admin.Polls.show', [
            'page_title' => ' تصويتات  ',
            'poll' => $poll,
        ]);
    }

    public function destroy($id)
    {
        $poll = Poll::findOrFail($id);
        $poll->delete();

        return redirect()->back()->with('success', 'Poll Deleted successfully');

    }

}

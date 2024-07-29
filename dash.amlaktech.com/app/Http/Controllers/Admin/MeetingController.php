<?php

namespace App\Http\Controllers\Admin;

use App\Http\Actions\Meeting\StoreMeetingHandler;
use App\Http\Actions\Meeting\UpdateMeetingHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Meeting\StoreMeetingRequest;
use App\Http\Requests\Meeting\UpdateMeetingRequest;
use App\Models\Association;
use App\Models\Meeting;
use App\Models\MeetingAgenda;
use App\Models\MeetingDecision;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Mews\Purifier\Facades\Purifier;
use Mpdf\Mpdf;

class MeetingController extends Controller
{

    public function index()
    {
        $meetings = Meeting::orderBy('id', 'DESC');

        if (!is_admin()) {
            $meetings = $meetings->whereAssociationId(get_association_id());
        }

        $meetings = $meetings->paginate(PAGINATION_LENGTH);

        return view('Admin.Meetings.Index', [
            'page_title' => trans('labels.meetings'),
            'meetings' => $meetings,
        ]);
    }


    public function create(Request $request, Meeting $meeting): JsonResponse
    {

        $associations = Association::orderBy('name', 'asc')->get();

        return response()->json([
            'data' => view('Admin.Meetings.create', [
                'page_title' => 'إضافة اجتماع',
                'url' => dashboard_route('meetings.store'),
                'meeting' => $meeting,
                'associations' => $associations
            ])->render()
        ]);
    }


    public function edit(Meeting $meeting): JsonResponse
    {
        $associations = Association::orderBy('name', 'asc')->get();

        return response()->json([
            'data' => view('Admin.Meetings.create', [
                'page_title' => 'تعديل الاجتماع',
                'url' => dashboard_route('meetings.update', $meeting->id),
                'meeting' => $meeting,
                'associations' => $associations
            ])->render()
        ]);
    }

    public function agendaModal(Meeting $meeting)
    {
        $agenda = $meeting->agenda()->first();

        return response()->json([
            'data' => view('Admin.Meetings.agenda', [
                'page_title' => 'محضر الاجتماع',
                'url' => dashboard_route('meetings.agenda', $meeting->id),
                'meeting' => $meeting,
                'agenda' => $agenda
            ])->render()
        ]);
    }

    public function agenda(Meeting $meeting)
    {
        return $this->redirectBack(MeetingAgenda::updateOrCreate([
            'meeting_id' => $meeting->id,
        ], [
            'meeting_id' => $meeting->id,
            'content' => Purifier::clean(request('content'))
        ]));
    }

    public function exportAgenda(Request $request, Meeting $meeting)
    {

        $mpdf = new Mpdf([
            'autoArabic' => true
        ]);

        $html = view('Admin.agenda-pdf', ['page_title' => 'محضر الاجتماع ' . $meeting->id, 'request' => $request])->render();

        $filename = 'uploads/agenda/Agenda of meeting ' . $meeting->id . '.pdf';

        $mpdf->WriteHTML($html);

        $mpdf->Output(public_path($filename), \Mpdf\Output\Destination::FILE);

        // Download the PDF file
        return response()->download(public_path($filename));
    }

    public function decisionsModal(Meeting $meeting)
    {
        $decisions = $meeting->decisions()->first();

        return response()->json([
            'data' => view('Admin.Meetings.decisions', [
                'page_title' => 'قرارات الاجتماع',
                'url' => dashboard_route('meetings.decisions', $meeting->id),
                'meeting' => $meeting,
                'decisions' => $decisions
            ])->render()
        ]);
    }

    public function decisions(Meeting $meeting)
    {
        return $this->redirectBack(MeetingDecision::updateOrCreate([
            'meeting_id' => $meeting->id,
        ], [
            'meeting_id' => $meeting->id,
            'content' => Purifier::clean(request('content'))
        ]));
    }

    public function store(StoreMeetingRequest $request)
    {
        (new StoreMeetingHandler($request))->handle();
        return redirect()->back()->with('success', 'Meeting created successfully');
    }

    public function update(UpdateMeetingRequest $request, Meeting $meeting)
    {
        (new UpdateMeetingHandler($request, $meeting))->handle();

        return redirect()->back()->with('success', 'Meeting updated successfully');
    }

    public function destroy($id)
    {
        $meeting = Meeting::findOrFail($id);

        $meeting->delete();

        return redirect()->back()->with('success', 'Meeting deleted successfully');
    }

}

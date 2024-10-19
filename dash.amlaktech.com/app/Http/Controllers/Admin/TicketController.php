<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ticket\UpdateTicketRequest;
use App\Services\TicketService;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TicketController extends Controller
{
    public function index(Request $request, Ticket $tickets)
    {
        $tickets = getOnlyObjectsAccordingToAdmin($tickets, 'association_id')->with('association', 'lastMessage');

        if ($request->ajax()) {

            return DataTables::eloquent($tickets)
                ->addIndexColumn()
                ->editColumn('code', function ($row) {
                    return "#{$row->code}";
                })
                ->addColumn('association', function ($row) {
                    return '<p class="m-0">' . $row?->association?->name . '</p>';
                })
                ->addColumn('category', function ($row) {
                    return '<p class="m-0">' . ($row?->category?->name ?? 'غير مصنف') . '</p>';
                })
                ->editColumn('created_at', function ($row) {
                    $out = '';

                    if (!is_null($row->created_at)) {
                        $out .= '<p class="m-0"><i class="fa fa-calendar text-success"></i> ' . $row->created_at->format('Y-m-d') . '</p>';
                        $out .= '<p class="m-0"><i class="fa fa-clock text-success"></i> ' . $row->created_at->format('H:i') . '</p>';

                        return $out;
                    }

                    return 'غير معروف';
                })
                ->editColumn('status', function ($row) {
//                    $out = '<div class="bg-' . ticketBadgeBG($row->status) . ' p-2 text-center rounded">' . __('labels.tickets_status.' . $row->status) . '</div>';
//
//                    if ($row->is_closed) {
//                        $out .= '<p class="text-secondary m-0">' . __('labels.tickets_status.closed') . '</p>';
//                    }
//
//                    return $out;

                    $status = TicketService::checkStatus($row->status, $row?->lastMessage);

                    return '<div class="bg-'.$status['color_type'].' p-2 text-center rounded">' . $status['text'] . '</div>';

                })
                ->addColumn('association', function ($row) {
                    return '<p class="m-0">' . $row?->association?->name . '</p>';
                })
                ->addColumn('member', function ($row) {
                    return '<p class="m-0">' . $row?->member?->name . '</p>';
                })
                ->addColumn('last_message', function ($row) {
                    $out = '';

                    if ($row?->lastMessage?->sender) {
                        $out .= '<p class="m-0">' . $row?->lastMessage?->sender?->name . '</p>';

                        if (!is_null($row?->lastMessage?->created_at))
                            $out .= '<p class="m-0">' . $row?->lastMessage?->created_at->diffForHumans(now()) . '</p>';

                        return $out;
                    }

                    return 'لا يوجد أي رد بعد.';
                })
                ->addColumn('action', function ($row) {
                    $out = '<div class="table-buttons">';
//                    $out .= '<a class="btn btn-primary btn-icon" href="'.dashboard_route('units.edit', $row->id).'" data-toggle="tooltip" title="تعديل الوحدة"><i class="fa fa-edit"></i></a>';

                    $out .= '<a href="' . dashboard_route('tickets.show', $row->id) . '" class="btn btn-primary btn-icon m-0 me-2"
                                               data-toggle="tooltip" title="عرض الطلب">
                                            <i class="fas fa-eye"></i>
                                        </a>';

                    $out .= '<form method="post" action="' . route('dashboard.tickets.destroy', $row->id) . '" style="display:inline-block;margin:0">';
                    $out .= csrf_field();
                    $out .= method_field('delete');
                    $out .= '<button type="submit" class="btn btn-secondary close-ticket btn-icon" data-toggle="tooltip" title="إغلاق الطلب"><i class="fas fa-comment-slash"></i></button>';
                    $out .= '</form>';

                    return $out;
                })
                ->filter(function ($query) use ($request) {

                    if ($request->association != '') {
                        $query->where('association_id', $request->association);
                    }

                }, true)
                ->orderColumn('association', function ($query, $order) {
                    $query->orderBy('association_id', $order);
                })
                ->orderColumn('id', function ($query, $order) {
                    $query->orderBy('id', $order);
                })
                ->filter(function ($query) use ($request) {
                    if ($request->search != '') {
                        $query->where('name', 'like', '%' . $request->search . '%')
                            ->orWhere('phone_number', 'like', '%' . $request->search . '%')
                            ->orWhere('email', 'like', '%' . $request->search . '%');
                    }
//
                    if ($request->association != '') {
                        $query->where('association_id', $request->association);
                    }

                }, true)
                ->setRowId(function ($row) {
                    return $row->id;
                })
                ->rawColumns(['name', 'association', 'category', 'member', 'code', 'last_message', 'status', 'action', 'created_at'])
                ->toJson();
        }

        return view('Admin.Tickets.index', [
            'page_title' => 'تذاكر الدعم',
            'users' => $tickets,
        ]);
    }

    public function show(Request $request, Ticket $ticket)
    {
        return view('Admin.Tickets.Show', [
            'page_title' => 'طلب #' . $ticket->code,
            'ticket' => $ticket,
            'messages' => $ticket->ticketMessages()->orderBy('id', 'DESC')->get()
        ]);
    }

    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {
        if (TicketService::updateOrCreateForAdmin($ticket))
            return redirect()->back()->with('success', 'تم اضافة ردك بنجاح، التذكرة الان بانتظار رد المالك.');

        return redirect()->back()->with('error', 'حدث خطأ ما، الرجاء المحاولة مرة أخرى.');
    }

    public function changeStatus(Ticket $ticket, string $status)
    {
        return $this->redirectBack($ticket->update([
            'status' => $status
        ]));
    }

    public function destroy(Ticket $ticket)
    {
        return $this->redirectBack($ticket->update(['status' => 'closed']));
    }
}

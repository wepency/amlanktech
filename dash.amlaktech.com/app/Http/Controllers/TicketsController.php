<?php

namespace App\Http\Controllers;

use App\Http\Requests\Ticket\StoreTicketRequest;
use App\Models\AssociationMember;
use App\Models\Ticket;
use App\Models\TicketMessage;
use App\Services\TicketService;
use Illuminate\Support\Facades\Auth;

class TicketsController extends Controller
{

    public function index()
    {
        $tickets = auth('member')->user()->tickets()->orderBy('id', 'desc')->with('lastMessage', 'ticketMessages')->withCount('ticketMessages')->get();

        return view('Frontend.Tickets.Index', [
            'page_title' => 'تذاكر الدعم',
            'tickets' => $tickets,
            'tickets_count' => $this->ticketsCount()
        ]);
    }

    public function show(Ticket $ticket)
    {
        return view('Frontend.Tickets.Show', [
            'page_title' => 'عرض تذكرة رقم ' . $ticket->code,
            'ticket' => $ticket,
            'tickets_count' => $this->ticketsCount()
        ]);
    }

    public function create(Ticket $ticket)
    {
        return view('Frontend.Tickets.create', [
            'page_title' => 'فتح التذكرة',
            'ticket' => $ticket,
            'associations' => auth('member')->user()->memberAssociations,
            'tickets_count' => $this->ticketsCount()
        ]);
    }

    public function store(StoreTicketRequest $request, Ticket $ticket)
    {

        try {

            $ticket = TicketService::updateOrCreate($ticket);

            return redirect('tickets/' . $ticket->id)->withMessage('تم فتح التذكرة بنجاح');

        } catch (\Exception $exception) {
            report($exception);
        }

        return redirect()->back()->withInput()->withError('برجاء التأكد من ادخال كل البيانات.');
    }

    private function ticketsCount()
    {
        $inProgress = clone $solved = clone $notSolved = auth('member')->user()->tickets();

        return [
            'not_solved' => $notSolved->notSolved()->count(),
            'solved' => $solved->solved()->count(),
            'in_progress' => $inProgress->inProgress()->count(),
        ];
    }
}

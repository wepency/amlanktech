<?php

namespace App\Http\Actions\Ticket;

use App\Models\Policy;
use App\Models\Ticket;
use Illuminate\Http\Request;

class StoreTicketHandler
{
    public function __construct(
        public Request $request
    ){}

    public function handle(): Ticket
    {

        $ticket = new Ticket();
        $ticket->title= $this->request->get('title');
        $ticket->status= $this->request->get('status');

        $ticket->save();

        return $ticket;
    }
}

<?php

namespace App\Http\Actions\Ticket;

use App\Models\Ticket;
use Illuminate\Http\Request;

class UpdateTicketHandler
{
    public string $message;

    public function __construct(
        public Request $request,
        public Ticket $ticket,
    )
    {
    }

    public function handle(): self
    {

        $this->ticket->name= $this->request->get('name');
        $this->ticket->ticket= $this->request->get('ticket');

        $this->ticket->save();

        $this->message = 'The Ticket Has Been Updated Successfully';

        return $this;
    }

}

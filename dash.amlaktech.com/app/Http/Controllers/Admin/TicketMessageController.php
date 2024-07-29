<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketMessage;
use Illuminate\Http\Request;

class TicketMessageController extends Controller
{
     
    public function index(Ticket $ticket)
    {

        $ticket = Ticket::findOrFail($ticket->id);

        $messages = $ticket->ticketMessages;
        return view('Admin.Tickets.Messages.Index', [
            'page_title' => ' الرسالة',
            'messages' => $messages,
            'ticket' => $ticket,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'body' => 'required|max:191',
            'ticket_id' => 'nullable|numeric',
        ]);

        if ($request->file('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/tickets'), $fileName);
    
            $imagePath = 'storage/tickets/' . $fileName;
    
            $data['image'] = $imagePath;
        }

        if(TicketMessage::create($data))
            return redirect()->back()->withSuccess('تم اضافة الرساله بنجاح.');

        return redirect()->back()->withError('هناك مشكلة في اضافة الرساله.');
    }

     
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'body' => 'required|max:191',
            'image' => 'nullable',
            'ticket_id' => 'nullable|numeric',
        ]);

        if($request->file('image')){
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/tichets'), $fileName); 
            $data['image'] = 'storage/tickets/' . $fileName; 
        }


        $message = TicketMessage::findOrFail($id);  

        if($message->update($data))
            return redirect()->back()->withSuccess('تم تعديل الرساله بنجاح.');

        return redirect()->back()->withError('هناك مشكلة في تعديل الرساله.');
    }

    public function destroy($id)
    {
        $message = TicketMessage::findOrFail($id);

        $message->delete();

        return redirect()->back()->with('success', 'message deleted successfully');
    }

}

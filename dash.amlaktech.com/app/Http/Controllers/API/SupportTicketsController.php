<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\SupportTicketsResource;
use App\Http\Resources\API\TicketAttachmentsResource;
use App\Models\Attachment;
use App\Models\Ticket;
use App\Models\TicketMessage;
use App\Traits\generateAPI;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class SupportTicketsController extends Controller
{
    use generateAPI;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $tickets = get_auth()->user()->tickets()->with('lastMessage')
            ->when(request()->filled('association_id'), function ($tickets) {
                $tickets->where('association_id', request()->association_id);
            })
            ->orderBy('created_at', 'desc')->get();

        return $this->success(['tickets' => SupportTicketsResource::collection($tickets)]);
    }

    public function store(Request $request, Ticket $ticket)
    {
        try {

            $request->validate([
                'subject' => 'required',
                'importance' => 'nullable|in:normal,average,urgent',
                'attachments' => 'nullable|array',
                'category_id' => 'required|numeric',
                'unit_id' => 'nullable|numeric',
            ]);

            DB::beginTransaction();

            $ticket = $ticket->create([
                'member_id' => get_auth()->id(),
                'association_id' => $request->association_id,
                'title' => $request->subject,
                'importance' => $request->importance == 'normal',
                'status' => 'inProgress',
                'category_id' => $request->category_id,
                'code' => rand(111111, 999999)
            ]);

            $ticketMessage = $ticket->ticketMessages()->create([
                'body' => $request->body,
                'ticket_id' => $ticket->id,
                'sender_id' => get_auth()->id(),
                'sender_type' => 'member',
                'stars' => $request->stars
            ]);

            $attachments = [];

            if (!is_null($request->attachments)) {
                foreach ($request->file('attachments') as $attachment) {

                    $filename = Str::slug($attachment->getClientOriginalName()) . '-' . rand(1111, 9999) . '.' . $attachment->getClientOriginalExtension();

                    if ($attachment->move('uploads/tickets', $filename))
                        $attachments[] = array(
                            'model_type' => get_class($ticketMessage),
                            'model_id' => $ticketMessage->id,
                            'filename' => $filename,
                            'path' => 'uploads/tickets/' . $filename,
                            'created_at' => now(),
                            'updated_at' => now()
                        );
                }
            }

            if (!empty($attachments))
                Attachment::insert($attachments);

            DB::commit();

            return $this->success(['تمت الاضافة بنجاح.']);

        } catch (ValidationException $e) {

            $errors = $e->validator->errors()->toArray();
            return $this->error([$errors], null, JsonResponse::HTTP_UNPROCESSABLE_ENTITY, false, false);

        } catch (\Exception $exception) {
            report($exception);
        }

        return $this->error(['هناك مشكلة في اضافة الطلب، برجاء التواصل مع الدعم الفني.']);
    }

    public function show(Request $request, Ticket $ticket)
    {
        $ticket->show_details = true;
        return $this->success(['ticket' => SupportTicketsResource::make($ticket)]);
    }

    public function addReply(Request $request, Ticket $ticket)
    {
        try {

            $request->validate([
                'reply' => 'required',
                'attachments' => 'nullable|array'
            ]);

            $attachments = [];

            if (!is_null($request->attachments)) {
                foreach ($request->file('attachments') as $attachment) {

                    $filename = Str::slug($attachment->getClientOriginalName()) . '-' . rand(1111, 9999) . '.' . $attachment->getClientOriginalExtension();

                    if ($attachment->move('uploads/tickets', $filename))
                        $attachments[] = array(
                            'model_type' => TicketMessage::class,
                            'model_id' => $ticket->id,
                            'filename' => $filename,
                            'path' => 'uploads/tickets/' . $filename,
                            'created_at' => now(),
                            'updated_at' => now()
                        );
                }
            }

            DB::beginTransaction();

            $ticket->ticketMessages()->create([
                'sender_id' => get_auth()->id(),
                'sender_type' => 'member',
                'body' => $request->reply
            ]);

            if (!empty($attachments))
                Attachment::insert($attachments);

            DB::commit();

            return $this->success(['تم اضافة الرد بنجاح.']);

        } catch (ValidationException $e) {

            // Customizing the validation error response
            $errors = $e->validator->errors()->toArray();

            return $this->error([$errors], null, JsonResponse::HTTP_UNPROCESSABLE_ENTITY, false, false);

        } catch (\Exception $exception) {
            report($exception);
        }

        return $this->error(['هناك مشكلة في اضافة الرد.']);
    }

    public function deleteReply(TicketMessage $message)
    {

        if ($message->sender_id == get_auth()->id() && $message->sender_type == 'member') {
            $message->delete();
            return $this->success(['تم الحذف بنجاح.']);
        }

        return $this->error(['ليس لديك صلاحيات لحذف الرد.'], 'error', 401);
    }

    public function others(Ticket $ticket)
    {
        $tickets = get_auth()->user()->tickets()
            ->when(request()->filled('association_id'), function ($tickets) {
                $tickets->where('association_id', request()->association_id);
            })
            ->orderBy('created_at', 'desc')->where('id', '!=', $ticket->id)->limit(5)->get();

        return $this->success(['tickets' => SupportTicketsResource::collection($tickets)]);
    }

    public function attachments(Ticket $ticket)
    {
        $ticketMessagesIds = $ticket->ticketMessages()->select('id')->get()->pluck('id')->toArray();
        $attachments = Attachment::where('model_type', TicketMessage::class)->whereIn('model_id', $ticketMessagesIds)->get();

        return TicketAttachmentsResource::collection($attachments);
    }

    public function applyAppeal(Ticket $ticket)
    {
        if ($ticket->update([
            'is_appealed' => 1
        ]))
            return $this->success(['تم تصعيد الطلب بنجاح الى ادارة الجمعية.']);

        return $this->error(['هناك مشكلة في تصعيد الطلب، برجاء التواصل مع الدعم الفني.']);
    }

    public function addRatingToReply(Request $request, TicketMessage $reply)
    {
        if($reply->update([
            'stars' => $request->stars
        ]))

            return $this->success(["تم اضافة التقييم بنجاح."]);

        return $this->error(['هناك مشكلة في اضافة التقييم، برجاء التواصل مع الدعم الفني.']);

    }
}

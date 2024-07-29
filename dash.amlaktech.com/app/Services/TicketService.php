<?php

namespace App\Services;

use App\Models\Ticket;
use App\Models\TicketMessage;
use Illuminate\Support\Facades\DB;

class TicketService
{
    public static function updateOrCreate(Ticket $ticket, $guard = 'member')
    {
        try {

            DB::beginTransaction();

            $status = 'notSolved';
            $code = $ticket->code ?? self::generateCode();

            if ($guard == 'member') {
                $ticketData = [
                    'title' => request('title'),
                    'member_id' => get_auth()->id(),
                    'code' => $code,
                    'body' => request('body'),
                    'status' => $status,
                    'importance' => request('importance'),
                    'association_id' => request('association_id')
                ];

                $ticket = auth($guard)->user()->tickets()->updateOrCreate([
                    'id' => $ticket->id
                ], $ticketData);
            }

            if (auth('admin')->check()) {
                $member = auth('admin')->user();
                $type = 'admin';
            }else {
                $member = auth('member')->user();
                $type = 'member';
            }

            TicketMessage::create([
                'ticket_id' => $ticket->id,
                'body' => request('body'),
                'sender_id' => $member->id,
                'sender_type' => $type
            ]);

            $file = request()->file('attachment');

            (new UploadService)->uploadMultiple($file, 'attachments', $ticket);

            DB::commit();

            return $ticket;

        } catch (\Exception $exception) {
            report($exception);
            DB::rollBack();
        }

        return false;
    }

    public static function updateOrCreateForAdmin(Ticket $ticket)
    {
        try {

            DB::beginTransaction();

            $ticket->update([
                'status' => 'answered'
            ]);

            TicketMessage::create([
                'ticket_id' => $ticket->id,
                'body' => request('body'),
                'sender_id' => dashboard_auth()->id(),
                'sender_type' => 'admin'
            ]);

            if (request()->hasFile('attachment')) {
                $file = request()->file('attachment');
                (new UploadService)->uploadMultiple($file, 'attachments', $ticket);
            }

            DB::commit();

            return $ticket;

        } catch (\Exception $exception) {
            report($exception);
            DB::rollBack();
        }

        return false;
    }

    public static function generateCode(): string
    {
        $code = rand(100000, 999999);

        if (Ticket::where('code', $code)->exists()) {
            return self::generateCode();
        }

        return $code;
    }

    public static function checkStatus($status, $lastMessage = null)
    {
        return match ($status) {
            'notSolved' => [
                'id' => 0,
                'name' => $status,
                'color_type' => 'secondary',
                'bg_color' => '#737f9e',
                'text' => trans('labels.tickets_status.'.$status),
            ],
            'solved' => [
                'id' => 2,
                'name' => $status,
                'color_type' => 'success',
                'bg_color' => '#22c03c',
                'text' => trans('labels.tickets_status.'.$status),
            ],
            'closed', checkIfTicketExpired($lastMessage) => [
                'id' => 1,
                'name' => 'pending',
                'color_type' => 'warning',
                'bg_color' => '#fbbc0b',
                'text' => trans('labels.tickets_status.'.$status),
            ],
            default => [
                'id' => 3,
                'name' => $status,
                'color_type' => 'danger',
                'bg_color' => '#ee335e',
                'text' => trans('labels.tickets_status.'.$status),
            ],
        };
    }
}

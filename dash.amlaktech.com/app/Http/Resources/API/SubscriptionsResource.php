<?php

namespace App\Http\Resources\API;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $paymentPeriod = $this->unit->payment_period ?? 1;

        $lastPaymentDate = $this->end_payment ? Carbon::parse($this->end_payment) : null;
        $nextPaymentDate = optional(clone $lastPaymentDate)?->addMonths($paymentPeriod);

        return [
            'id' => $this->id,
            'unit' => UnitsResource::make($this->unit),
            'association' => [
                'id' => $this?->association?->id,
                'name' => $this?->association?->name
            ],

            'due_date' => $this->end_payment,
            'unit_price' => $this->amount,
            'payment_term' => $this->amount,
            'total' => $this->total,

            'payment_period' => $paymentPeriod,
            'payment_period_text' => trans('labels.payment_periods.'.$paymentPeriod),

            'last_payment_date' => optional($lastPaymentDate)->format('d/m/Y') ?? null,
            'next_payment_date' => optional($nextPaymentDate)->format('d/m/Y') ?? null,

            'status' => [
                'id' => $this->is_paid ?? 0,
                'text' => $this->is_paid ? 'مدفوع' : 'بانتظار الدفع',
                'name' => $this->is_paid ? 'paid' : 'pending',
                'bg_color' => $this->is_paid ? '#22c03c' : '#ee335e'
            ]
        ];
    }
}

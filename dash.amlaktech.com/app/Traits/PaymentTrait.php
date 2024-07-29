<?php

namespace App\Traits;

use Illuminate\Support\Facades\Config;

trait PaymentTrait
{

    protected function getClass($model, $value)
    {
        $modelClass = Config::get('payment.payment_classes.' . $model);

        if (in_array($model, ['wallet', 'partner_wallet'])) {
            return new $modelClass;
        }

        return (new $modelClass)->findOrFail($value);
    }

    public function makeTrackID($model, $userId, $value): string
    {
        return $model . '_' . $userId . '_' . rand(1, 9999) . '_' . $value;
    }

    public function getTrackIDParams($trackID): array
    {
        // Extract model, user ID, and value from track ID
        $arr = explode('_', $trackID);

        return [
            'model' => $arr[0],
            'user_id' => $arr[1],
            'value' => end($arr)
        ];
    }

    protected function redirectLink($type)
    {
        return match($type) {
            // Define the redirect links based on the provided type
            'booking', 'wallet' => [
                'success' => url('/user?tap=reservations'),
                'failed' => url('payment-failed'),
            ],
            'partner_wallet', 'contract', 'invoice' => [
                'success' => partner_route('success_payment'),
                'failed' => '',
            ],
            default => [
                'success' => '',
                'failed' => '',
            ],
        };
    }

    public function getAmountToPayOfModel($model, $value) {
        if (in_array($model, ['wallet', 'partner_wallet'])) {
            return $value;
        }

        $modelOBJ = $this->getClass($model, $value);

        return match ($model) {
            'booking' => match ($modelOBJ->status) {
                NULL, 0 => down_payment($modelOBJ->total, $modelOBJ->down_payment_percent),
                1 => full_payment($modelOBJ->total, $modelOBJ->down_payment_percent, $modelOBJ->insurance),
                default => false
            },
            'contract' => $modelOBJ->total
        };
    }
//    public function approveBooking() {}
//    public function addWalletBalance() {}
//    public function approveContractPayment() {}
//    public function approveContract() {}
//    public function approveInvoice() {}
}

<?php

namespace App\Traits;

use Carbon\Carbon;

trait UnitTrait
{
    private array $colors = [
        'warning' => [
            'bg_color' => '#fbc02d',
            'color' => '#333333'
        ],
        'success' => [
            'bg_color' => '#0097a7',
            'color' => '#ffffff'
        ],
        'danger' => [
            'bg_color' => '#d2190b',
            'color' => '#ffffff'
        ],
        'primary' => [
            'bg_color' => '#1976d2',
            'color' => '#ffffff'
        ],
    ];

    public function getStatus($unit)
    {
        if ($unit->valid_to < Carbon::now() && !is_null($unit->valid_to)) {
            return [
                    'text' => trans('partners.unit_status.expired'),
                ] + $unit->colors['warning'];
        } elseif ($unit->status == 1) {
            return [
                    'text' => trans('partners.unit_status.active'),
                ] + $unit->colors['success'];
        } elseif (is_null($unit->status)) {
            return [
                    'text' => trans('partners.unit_status.pending'),
                ] + $unit->colors['warning'];
        }

        return [
                'text' => trans('partners.unit_status.terminated'),
            ] + $unit->colors['danger'];
    }

    public function getStatusNote()
    {
        if (!is_null($this->note)) {
            return $this->note;
        }

        return null;
    }

    public function getBookingStatus($unit)
    {
        $status =  [
                'text' => trans('partners.unit_status.not_yet'),
            ] + $unit->colors['danger'];

        if ($unit->booking_status) {
            $status =  [
                    'text' => trans('partners.unit_status.active'),
                ] + $unit->colors['success'];
        }

        if ($unit->need_approval) {
            $status =  [
                    'text' => trans('partners.unit_status.waiting_approval'),
                ] + $unit->colors['warning'];
        }

        if ($unit?->details?->edit_status) {
            $status =  [
                    'text' => trans('partners.unit_status.edit_refused'),
                ] + $unit->colors['danger'];
        }

        return $status;
    }

    public function getBookingStatusNote($unit)
    {
        if (!is_null($unit?->details?->edit_note)) {
            return $unit->details->edit_note;
        }

        return null;
    }
}

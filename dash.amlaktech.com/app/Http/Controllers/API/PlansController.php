<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Traits\generateAPI;
use Illuminate\Http\Request;

class PlansController extends Controller
{
    use generateAPI;

    public function index()
    {
        return [
            [
                'id' => 1,
                'name' => 'باقة التجمع العقاري السكني الاساسيه',
                'yearly_price' => 7999,
                'monthly_price' => null,
                'setup_fees' => 2999,
                'description' => [
                    'عدد مستخدمين لا محدود',
                    'مؤشرات ورسوم بيانية',
                    'نظام محاسبي آلي متكامل',
                    'تقارير تفصيلية',
                    'نظام طلبات الصيانة',
                    'نظام طرح المنافسات',
                    'نظام التواصل الداخلي بين المالك',
                    'منشورات الدعاية واإلعالن',
                    'تشغيل و صيانة شاملة للنظام مدة االشتراك',
                    'نظام التصاريح الأمنية للزوار'
                ]
            ]
        ];
    }

    public function show($planId)
    {
        return $this->success(['plan' => [
            'id' => 1,
            'name' => 'باقة التجمع العقاري السكني الاساسيه',
            'yearly_price' => 7999,
            'monthly_price' => null,
            'setup_fees' => 2999,
            'description' => [
                'عدد مستخدمين لا محدود',
                'مؤشرات ورسوم بيانية',
                'نظام محاسبي آلي متكامل',
                'تقارير تفصيلية',
                'نظام طلبات الصيانة',
                'نظام طرح المنافسات',
                'نظام التواصل الداخلي بين المالك',
                'منشورات الدعاية واإلعالن',
                'تشغيل و صيانة شاملة للنظام مدة االشتراك',
                'نظام التصاريح الأمنية للزوار'
            ]
        ]
        ]);
    }
}

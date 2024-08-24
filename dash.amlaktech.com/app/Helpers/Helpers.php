<?php

use Carbon\Carbon;

function dashboard_title($page_title = null)
{
    $name = 'لوحة تحكم ' . config('app.name');
    $separator = !\Illuminate\Support\Facades\Route::is('dashboard.') ? ' | ' : '';
    $page_title = isset($page_title) ? $page_title : '';

    return $page_title . $separator . $name;
}

function clean_image_path($image_path)
{
    $image_path = str_replace(['[', ']', '"', '\''], '', $image_path);
    return trim($image_path);
}

function filter_phone_number($phonenumber)
{
    $phonenumber = ltrim($phonenumber, '0');
    return ltrim($phonenumber, '+966');
}

function hiven_slug($slug)
{
    return str_replace('-', '_', $slug);
}

function partner_route($route = null, $attrs = null)
{

    if (is_null($route))
        return route('partner.home');

    return route('partner.' . $route, $attrs);
}

function partner_auth()
{
    if (auth('partner_api')->check())
        return auth('partner_api');

    return auth('partner');
}

function dashboard_auth()
{
    return auth('admin');
}

function get_user_image($guard = null)
{
    if (auth($guard)->check()) {
        $image = auth($guard)->user()->image_url;

        if (file_exists('uploads/partners/' . $image) && !is_null($image)) {
            return asset('uploads/partners/' . $image);
        }

        return 'https://eu.ui-avatars.com/api/?size=128&rounded=true&bold=true&background=395590&color=fff&name=' . auth($guard)->user()->name;
    }
}

function checkIfTicketExpired($lastTicketMessage)
{
    return $lastTicketMessage?->sender_type == 'admin' && optional($lastTicketMessage?->created_at)->diffInDays(now()) > 2;
}

function canApplyAppeal($lastTicketMessage, $appealPeriod = 2)
{
    return $lastTicketMessage->sender_type == 'member' && optional($lastTicketMessage->created_at)->diffInDays(now()) >= $appealPeriod;
}

function calculateUnitFees($unitPrice, $amount): string
{
    return $unitPrice * $amount;
}

function calculateUserFees($units): string
{
    $total = 0;

    foreach ($units as $unit) {
        $total += calculateUnitFees($unit, $unit->pivot->amount);
    }

    return $total;
}

function get_user_title(): string
{
    if (auth('member')->check()) {
        return 'عضو جمعية';
    }

    $role = auth('admin')->user()->roles()?->first();

    if (!is_null($role))
        return $role->main_name;
//    if (auth('admin')->user()->role_title == 'manager') {
//        return 'مدير جمعية';
//    }

    return 'ادارة التطبيق';
}

function get_unit_info($unit)
{
    $out = '<p class="text-success mb-0">' . $unit?->unit_no . '</p>';
    $out .= '<p class="text-dark mb-0">' . $unit?->associationMember?->name . '</p>';

    return $out;
}

function get_badge($status)
{
    switch ($status) {
        case 1:
            $output = "<span class='badge badge-status badge-floating badge-success'>فعال</span>";
            break;
        default:
            $output = "<span class='badge badge-status badge-floating badge-danger'>غير فعال</span>";
            break;
    }

    return $output;
}

function ticketBadgeBG($status)
{
    return match ($status) {
        'inProgress' => 'warning',
        'solved' => 'success',
        default => 'primary',
    };
}

function check_route($prefix, $routes)
{
    foreach ($routes as $route) {
        $is_route = \Route::is($prefix . $route);

        if ($is_route) return true;
    }
}

function table_color_request($unit)
{
    if ($unit->status === 0) {
        return "table-warning";
    } elseif ($unit->status === 1) {
        return "";
    } else {
        return "table-danger";
    }
}

function currency($price)
{
    return number_format(floatval($price), 2) . ' ' . trans('labels.currency');
}

function currency_trans($price)
{
    return number_format(floatval($price), 2) . ' ' . __('labels.currency');
}

function currency_format($number)
{
    return currency(number_format($number, 2));
}

function can_access_admin_portal()
{
    return auth('admin')->check();
}

function get_admin_id(): ?bool
{
    if (can_access_admin_portal()) {
        return auth('admin')->id();
    }

    return null;
}

function get_association_id(): ?int
{
    if (can_access_admin_portal() && !is_admin()) {
        return auth('admin')->user()->association_id;
    }

    return null;
}

function is_admin()
{
    if (can_access_admin_portal()) {
        return auth('admin')->user()->role == 'admin';
    }

    return false;
}

function sendSMS($phone_number, $msg)
{
    $response = \Illuminate\Support\Facades\Http::post(env("MSEGAT_BASE"), [
        "userName" => env('MSEGAT_USERNAME'),
        "numbers" => '+966' . $phone_number,
        "userSender" => env('MSEGAT_USERSENDER'),
        "apiKey" => env("MSEGAT_APIKEY"),
        "msg" => $msg
    ]);

    // Check if the request was successful
    if ($response->successful()) {
        // Get the response content
        $responseData = $response->body();
        \Illuminate\Support\Facades\Log::debug($responseData);
        return $responseData;
    } else {
        // Handle the case where the request was not successful
        \Illuminate\Support\Facades\Log::error('SMS request failed. Status code: ' . $response->status());
        return null; // You may want to handle errors differently
    }
}

function getCurrentPageURL()
{
    return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
}

function is_manager()
{
    if (can_access_admin_portal()) {
        return auth('admin')->user()->role == 'manager';
    }

    return false;
}

function is_employee()
{
    if (can_access_admin_portal()) {
        return auth('admin')->user()->role == 'employee';
    }

    return false;
}

function pad_code($code, $len = 6)
{
    return str_pad($code, $len, '0', STR_PAD_LEFT);
}

function numbers_api($number)
{
    return number_format($number, 2, '.', '');
}

function get_auth()
{
    foreach (config('auth.guards') as $key => $guard) {
        if (auth($key)->check())
            return auth($key);
    }

    return false;
}

function get_user_model()
{
    foreach (['admin', 'partner', 'web'] as $key => $guard) {
        if (auth($guard)->check())
            return $guard;
    }

    return false;
}

function is_date_before($date): bool
{
    return Carbon::parse($date)->isBefore(now());
}

function get_user_avatar($name)
{
    return "https://eu.ui-avatars.com/api/?size=128&rounded=true&bold=true&background=363A76&color=fff&name={$name}";
}

function can($permission): bool
{
    $permission = checkIfCanNeedleExists($permission);
    return auth('admin')->user()->can($permission);
}

function canAnd($permissions): bool
{
    $permissions = convertToArray($permissions);
    $permissions = checkIfCanNeedleExists($permissions);

    return auth('admin')->user()->can($permissions);
}

function canOr($permissions): bool
{
    $permissions = convertToArray($permissions);
    $permissions = checkIfCanNeedleExists($permissions);

    foreach ($permissions as $permission) {
        if (auth('admin')->user()->can($permission))
            return true;
    }

    return false;
}

function convertToArray($data)
{
    return collect($data)->toArray();
}

function checkIfCanNeedleExists($permissions)
{
    $permissionResponse = [];

    if (!is_array($permissions))
        $permissions = [$permissions];

    foreach ($permissions as $permission) {
        $permissionResponse[] = strpos($permission, 'can') > -1 ? $permission : 'can ' . $permission;
    }

    return $permissionResponse;
}


function dashboard_route($url = null, $attr = null): string
{

    if (is_null($url))
        return route('dashboard.home');

    return route('dashboard.' . $url, $attr);
}

function get_locale()
{
    return \LaravelLocalization::getCurrentLocale();
}

function get_locale_dir()
{
    return \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocaleDirection();
}

function omega_link($uuid): string
{
    return 'https://api.omegastream.net/stream/company/processed-enterprise-media/c45f3c65/video/' . $uuid . '/playlist.m3u8';
}

function get_image_path($dir, $image)
{
    if (file_exists(public_path('uploads/' . $dir . '/' . $image)) && $image != '') {
        return asset('uploads/' . $dir . '/' . $image);
    }

    return asset('assets/images/placeholder.png');
}

function get_image_path_bool($dir, $image)
{
    if (file_exists(public_path('uploads/' . $dir . '/' . $image)) && $image != '') {
        return asset('uploads/' . $dir . '/' . $image);
    }

    return false;
}

function delete_image($dir, $image): bool
{
    if (file_exists(public_path('uploads/' . $dir . '/' . $image)) && $image != '') {
        return unlink('uploads/' . $dir . '/' . $image);
    }

    return true;
}

function check_array_key($key, $array)
{
    return array_key_exists($key, $array) && !empty($array[$key]);
}

// Language
function get_current_language()
{
    return \LaravelLocalization::getCurrentLocale();
}

function get_current_direction()
{
    return \LaravelLocalization::getCurrentLocaleDirection();
}

function month_name($date)
{
    return __('labels.months.' . (strtolower(\Carbon\Carbon::parse($date)->format('M'))));
}

function filter_phone($phone): int
{
    return ltrim($phone, '0');
}


function parse_normal_date($date)
{
    return Carbon::parse($date)->format('Y-m-d');
}

function hijri_date($date)
{
    return (new \App\Classes\Hijri(Carbon::parse($date)))->format('D _j _M _Yهـ');
}

function checkIfSerialized($data)
{
    $data = @unserialize($data);
    return $data !== false;
}

function serializedToArray($serialized)
{
    $unserialized = unserialize($serialized);

    if (is_string($unserialized)) {
        $arrayData = json_decode($unserialized, true);
        if (is_array($arrayData)) {
            return $arrayData;
        }
    }

    return $unserialized;
}

function get_formatted_time($hours = 0, $minutes = 0)
{

    if ($hours == 12) {
        $dim = 'ظهراََ';
    } elseif ($hours > 12) {
        $hours = $hours - 12;
        $dim = 'مساءاََ';
    } elseif ($hours == 0) {
        $hours = 12;
        $dim = 'منتصف الليل';
    } else {
        $dim = 'صباحاََ';
    }

    $hours = pad_code($hours, 2);
    $minutes = pad_code($minutes, 2);

    return "{$hours}:{$minutes} {$dim}";
}

function calculateFeesForMember($associationAmount, $memberAmount): string
{
    return currency($associationAmount * $memberAmount);
}

function getTaskProgress($task)
{
    if ($task->target_date > now()) {
        return 100;
    }

    $diff = $task->target_date->diffInDays();
    $minusAmount = (int)($diff / 10);

    return 100 - ($minusAmount * 5);
}

function getTaskProgressBG($progress)
{
    if ($progress >= 95) {
        return 'success';
    }

    if ($progress > 75) {
        return 'warning';
    }

    return 'danger';
}

function getAssociations()
{
    return \App\Models\Association::select('id', 'name')->orderBy('name', 'asc')->get();
}

function getAssociationId()
{
    if (!is_admin()) {
        return auth('admin')->user()->association_id;
    }

    return request()->association_id ?? null;
}

function checkManagerSubscription()
{
    $startDate = auth('admin')->user()?->association?->subscription_start_date;
    $endDate = Carbon::parse($startDate)->addYear();
    return Carbon::now()->diffInDays($endDate) < 7 || Carbon::now() > $endDate;
}

function convertJsonToArray($input): array
{
    // Check if the input is a JSON string
    if (is_string($input) && is_array(json_decode($input, true)) && (json_last_error() == JSON_ERROR_NONE)) {
        return json_decode($input, true);
    } // Check if the input is already an array
    elseif (is_array($input)) {
        return $input;
    } // If the input is neither JSON encoded nor an array, return an empty array
    else {
        return [];
    }
}

function generateUnitCode()
{
    $unitCode = rand(100000, 999999);

    if (\App\Models\Unit::where('unit_no', $unitCode)->exists()) {
        return generateUnitCode();
    }

    return $unitCode;
}

function subPeriodText($subPeriod)
{
    return match ($subPeriod) {
        3 => 'ربع سنوي',
        6 => 'نصف سنوي',
        12 => 'سنوي',
        default => 'شهري',
    };
}

function getOnlyObjectsAccordingToAdmin($object, $association)
{
    if (!is_admin()) {
        $associationId = auth('admin')->user()->association_id;
        return $object->where($association, $associationId);
    }

    return $object;
}

function getUserRequestCount()
{
    $user = \App\Models\User::notActive();

    if (!is_admin()) {
        $user = $user->whereHas('association', function ($query){
            return $query->where('id', getAssociationId());
        });
    }

    return $user->count();
}

function getReactionString($type = '')
{
    return match ($type) {
        1 => 'like',
        0 => 'dislike',
        default => '',
    };
}

function getUserTitle($sender)
{
    return match ($sender) {
        'admin' => 'مدير',
        'manager' => 'رئيس الجمعية',
        'employee' => 'موظف',
        'outsource' => 'موظف خارج النظام',
        default => 'مالك',
    };
}

function getPermitsRequests()
{
    $permits = \App\Models\Permit::whereNull('status');

    if (!is_admin()) {
        $associationId = auth('admin')->user()->association_id;
        $permits = $permits->where('association_id', $associationId);
    }

    return $permits->count();
}

function generateBookingCode($length = 8)
{
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $code = '';

    for ($i = 0; $i < $length; $i++) {
        $code .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $code;
}

/* User association checks */
function checkIfUserInAssociation($associationId)
{
    return \App\Models\AssociationsMembers::where('association_id', $associationId)->where('user_id', get_auth()->id())->get();
}

function getAllMemberAssociations($userId = null)
{
    $userId = is_null($userId) ? get_auth()->id() : $userId;
    return \App\Models\AssociationsMembers::where('user_id', $userId)->get()->pluck('association_id')->toArray();
}

function getUserAvatar()
{
    return asset('assets/images/user.png');
}

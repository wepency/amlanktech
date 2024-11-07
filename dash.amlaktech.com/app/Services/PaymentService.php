<?php

namespace App\Services;

use App\Classes\Payment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    protected $models = [
        'App\Models\Bookings',
        'App\Models\UserWallet',
        'App\Models\PartnerWallet',
        'App\Models\Invoice'
    ];

    private static string $terminalId;
    private static string $password;
    private static string $merchant_key;
    private static string $currencycode;
    private static string $requestURL;

    public function __construct()
    {
        $env_type = ''; // TEST_, ''

        self::$terminalId = env('URWAY_' . $env_type . 'TERMINALID');
        self::$password = env('URWAY_' . $env_type . 'PASSWORD');
        self::$merchant_key = env('URWAY_' . $env_type . 'MERCHANT_KEY');
        self::$currencycode = env('URWAY_' . $env_type . 'CURRENCY_CODE');
        self::$requestURL = env('URWAY_' . $env_type . 'REQUEST_URL');
    }

    public function checkStatus($request): bool
    {
        $terminalId = self::$terminalId;
        $password = self::$password;
        $key = self::$merchant_key;

        $requestHash = "{$request->input('TranId')}|{$key}|{$request->input('ResponseCode')}|{$request->input('amount')}";
        $txn_details1 = "{$request->input('TrackId')}|{$terminalId}|{$password}|{$key}|{$request->input('amount')}|SAR";

        $hash = hash('sha256', $requestHash);

        if ($hash !== $request->input('responseHash')) {
            return false;
        }

        $requestHash1 = hash('sha256', $txn_details1);

        try {
            $response = Http::timeout(5)->withHeaders([
                'Content-Type' => 'application/json',
            ])->post(self::$requestURL, [
                'trackid' => $request->input('TrackId'),
                'terminalId' => $terminalId,
                'action' => '10',
                'merchantIp' => "",
                'password' => $password,
                'currency' => "SAR",
                'transid' => $request->input('TranId'),
                'amount' => $request->input('amount'),
                'udf5' => "",
                'udf3' => "",
                'udf4' => "",
                'udf1' => "",
                'udf2' => "",
                'requestHash' => $requestHash1
            ]);

            $apiresult = $response->json();
            $inquiryResponsecode = $apiresult['responseCode'];
            $inquirystatus = $apiresult['result'];

            if ($request->input('Result') === 'Successful' && $request->input('ResponseCode') === '000') {
                if ($inquirystatus == 'Successful' || $inquiryResponsecode == '000') {
                    return $apiresult;
                }
            }
        } catch (\Exception $e) {
            // Handle the exception
            Log::debug($e->getMessage());
            // Log or handle the error as needed
            // You can also throw a custom exception or return an error response
            return false;
        }

        return false;
    }

    public static function get_server_ip() {
        $ipaddress = '';

        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

    public static function payInfo($idorder, $amount, $response_url, $model_type = null, $model_id = null, $user_type = null, $user_id = null)
    {
        $terminalId = self::$terminalId;
        $password = self::$password;
        $merchant_key = self::$merchant_key;
        $currencycode = self::$currencycode;

        $ipp = '128.0.0.1';
        $amount = numbers_api($amount);

        $txn_details = $idorder . '|' . $terminalId . '|' . $password . '|' . $merchant_key . '|' . $amount . '|' . $currencycode;
        $hash = hash('sha256', $txn_details);

//        $fields = [
//            'trackid' => $idorder,
//            'terminalId' => $terminalId,
//            'customerEmail' => 'ahmedyassersalama@email.com',
//            'action' => "1",
//            'merchantIp' => $ipp,
//            'password' => $password,
//            'currency' => $currencycode,
//            'country' => "SA",
//            'amount' => numbers_api($amount),
//            "udf1" => "Test1",
//            "udf2" => $response_url,
//            "udf3" => "",
//            "udf4" => "",
//            "udf5" => "Test5",
//            'requestHash' => $hash
//        ];

        $fields = array(
            'trackid' => $idorder,
            'terminalId' => $terminalId,
            'customerEmail' => 'customer@email.com',
            'action' => "1",  // action is always 1
            'merchantIp' =>$ipp,
            'password'=> $password,
            'currency' => $currencycode,
            'country'=>"SA",
            'amount' => $amount,
            "udf1"              =>"Test1",
            "udf2"              =>"https://amlacktech.com",//Response page URL
            "udf3"              =>"",
            "udf4"              =>"",
            "udf5"              =>"Test5",
            'requestHash' => $hash  //generated Hash
        );


//        try {
        $result = Http::timeout(5)->withHeaders([
            'Content-Type' => 'application/json',
        ])->post(self::$requestURL, $fields);

        if (!empty($result['payid']) && !empty($result['targetUrl'])) {
//            self::createTransaction($result['payid'], $idorder, $model_type, $model_id, $user_type, $user_id);
            return $result['targetUrl'] . '?paymentid=' . $result['payid'];
        }

//        } catch (\Exception $e) {
//            // Handle the exception
//            Log::debug($e->getMessage());
//            // Log or handle the error as needed
//            // You can also throw a custom exception or return an error response
//            return "Error".$e->getMessage();
//        }

        return null;
    }
}

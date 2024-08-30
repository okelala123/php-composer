<?php
namespace App\Services;

class Webhook
{
    public function handleSignature($payload, $requestTime, $secretKey)
    {
        ksort($payload);
        // print_r($payload);
        $payloadString = json_encode($payload);

        $signatureString = $requestTime . $payloadString;

        return hash_hmac('sha256', $signatureString, $secretKey);
    }
}



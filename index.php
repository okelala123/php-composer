<?php

use App\Services\VifoOrder;
use App\Services\VifoSendRequest;
use App\Services\VifoServiceFactory;
use App\Services\VifoTerminate;

require 'vendor/autoload.php';

$test = new VifoServiceFactory('dev');
$test->login();

echo "<br/>";
echo "<br/>";
echo "<br/>";
echo "<br/>";
echo "<br/>";
echo "<br/>";
$order = $test->getOrder();

$rspData = $order->createOrder('1231231231223');

if ($rspData) {
    $distributor_id = $rspData['data']['id'];

    $rspDataHeaders = $order->getHeaders();
}



echo "<br/>";
echo "<br/>";
echo "<br/>";
echo "<br/>";
echo "<br/>";
echo "<br/>";
// var_dump($rspData['data']['id']);
// var_dump($rspData1);

$terminate = new VifoTerminate($distributor_id, $rspDataHeaders);
$terminate->handlerTerminate();

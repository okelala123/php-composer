<?php

namespace App\Services;

class VifoOrder
{
    private $headers;
    private $sendRequest;

    public function __construct($headers)
    {
        $this->headers = $headers;
        $this->sendRequest = new VifoSendRequest();
    }

    public $isDebug = false;

    private function getOrderData($distributor_order_number)
    {
        return [
            'distributor_order_number' => $distributor_order_number,
            'product_code' => 'REVAVF240101',
            'phone' => '0972640911',
            'email' => '',
            'address' => '1196 Đường 3 Tháng 2, phường 8, Quận 11, Thành phố Hồ Chí Minh, Việt Nam',
            'final_amount' => 50000,
            'bank_detail' => false,
            'qr_type' => '',
            'end_date' => null,
        ];
    }
    public function createOrder($distributor_order_number)
    {

      $orderData = $this->getOrderData($distributor_order_number);

        $endpoint = '/v2/finance';
        try {
            $response = $this->sendRequest->sendRequest('POST', $endpoint, $this->headers, $orderData);
            return $response;
        } catch (\Exception $e) {
            if ($this->isDebug) {
                return $e;
            }
            throw new \Exception("Order creation failed: " . $e->getMessage());
        }
    }
    public function getHeaders()
    {
        return $this->headers;
    }
}

<?php 
namespace App\Services;

class VifoTerminate{
    private $headers;
    private $distributor_id;
    private $sendRequest;
    public function __construct($distributor_id,$headers)
    {
        $this->distributor_id = $distributor_id;
        $this->headers = $headers;
        $this->sendRequest = new VifoSendRequest();
    }

    public function handlerTerminate()
    {
        $endpoint = '/v2/finance/'.$this->distributor_id.'/terminate';
        try{
            $this->sendRequest->sendRequest('PUT', $endpoint, $this->headers,[]);

        } catch (\Exception $e) {
            throw new \Exception("Terminate  failed: " . $e->getMessage());
        }
    }
}
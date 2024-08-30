<?php 
namespace App\Services;
class VifoServiceFactory{

    private $sendRequest;
    private $auth;
    private $mode;
    public $order;
    public $terminate;

    public $headers = [
        'Content-Type' => 'application/json',
        'Accept' => 'application/json'
    ];

    public function __construct(String $env = 'dev')
    {
        $this->mode = $env;
        $this->sendRequest = new VifoSendRequest($env);
        $this->auth = new VifoAuthenticate();
    }

    public function login()
    {
        $headers = $this->headers;
        $endpoint = '/v1/clients/web/admin/login';
        $body =  $this->auth->login();
        $response= $this->sendRequest->sendRequest('POST',$endpoint,$headers,$body);

        if ($response && isset($response['access_token'])) {
            $this->headers['Authorization'] = 'Bearer ' . $response['access_token'];
            // echo "Access Token: " . $response['access_token'] . "<br/>";
            // print_r($this->headers)."<br/>"; 
        } else {
            echo "Login failed";
        }
    }
    

    public function getOrder()
    {
        return $this->order = new VifoOrder($this->headers);
    }

    
  
}
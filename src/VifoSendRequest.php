<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Namshi\Cuzzle\Middleware\CurlFormatterMiddleware;
use Monolog\Logger;
use Monolog\Handler\TestHandler;
use GuzzleHttp\Exception\RequestException;

class VifoSendRequest
{
    private $baseUrl;
    private $client;
    private $logger;
    private $testHandler;
    private $terminate;
    private  $headers;
    private  $distributor_id = null;
    public function __construct($env = 'dev')
    {
        if ($env == 'dev') {
            $this->baseUrl = 'https://sapi.vifo.vn';
        } else if ($env == 'tsg') {
            $this->baseUrl = 'https://sapi.vifo.vn';
        } else {
            $this->baseUrl = 'https://api.vifo.vn';
        }

        // Khởi tạo logger
        $this->logger = new Logger('guzzle.to.curl');
        $this->testHandler = new TestHandler();
        $this->logger->pushHandler($this->testHandler);

        // Cài đặt handler stack với CurlFormatterMiddleware
        $handler = HandlerStack::create();
        $handler->after('cookies', new CurlFormatterMiddleware($this->logger));

        // Khởi tạo client Guzzle với handler
        $this->client = new Client(['handler' => $handler]);
    }

    public function sendRequest($method, $endpoint, $headers, $body)
    {

        $baseUrl = $this->baseUrl . $endpoint;
        try {

            $response = $this->client->request($method, $baseUrl, [
                'headers' => $headers,
                'json' => $body
            ]);
            echo "Status Code: " . $response->getStatusCode() . "<br/>";
            echo "Response Body: " . $response->getBody() . "<br/>";
            $json = json_decode($response->getBody(), true);

            if ($json === null && json_last_error() !== JSON_ERROR_NONE) {
                echo "Lỗi khi giải mã JSON: " . json_last_error_msg();
                return;
            }
        } catch (RequestException $e) {
            echo "Request failed: " . $e->getMessage() . "<br/>";
            echo "Response Body: " . $e->getResponse()->getBody() . "<br/>";
            var_dump($this->testHandler->getRecords()) . "<br/>";
        }

        return $json;
    }
}

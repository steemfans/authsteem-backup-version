<?php
namespace App\Lib\Steem;
use Log;
use GuzzleHttp\Client;

class Steem {
    protected $baseUrl;
    protected $timeout;

    public function __construct() {
        $this->baseUrl = env('STEEM_API', 'https://api.steemit.com');
        $this->timeout = env('TIMEOUT', 10);
    }

    public function getAccount($accountName = 'authsteem') {
        $data = $this->dataFactory('condenser_api.get_accounts', [[$accountName]]);
        $response = $this->sendData($data);
        if ($response === false) {
            return false;
        }
        if ($response->getStatusCode() === 200) {
            $result = json_decode($response->getBody()->getContents(), true);
            return $result['result'];
        } else {
            Log::warning('response_status_code_not_200', [$response]);
            return false;
        }
    }

    protected function dataFactory($method = 'condenser_api.get_dynamic_global_properties', $params = [], $id = 1) {
        return [
            'jsonrpc' => '2.0',
            'method' => $method,
            'params' => $params,
            'id' => $id,
        ];
    }

    protected function sendData($data, $method = 'POST') {
        $client = new Client([
            'base_uri' => $this->baseUrl,
            'timeout' => $this->timeout,
        ]);
        try {
            return $client->request($method, $this->baseUrl, [
                'json' => $data,
            ]);
        } catch(\Exception $e) {
            Log::error('steem_api_send_data_failed', [$e->getMessage(), $data]);
            return false;
        }
    }
}

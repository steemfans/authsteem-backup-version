<?php
namespace App\Lib\Steem;
use Log;

class JsBridge {
    protected $jsBridgeUrl;
    protected $timeout;

    public function __construct() {
        $this->jsBridgeUrl = env('JS_BRIDGE_URL', 'https://js-bridge.steemtools.top');
        $this->timeout = env('JS_BRIDGE_TIMEOUT', 60);
    }

    public function authLogin($username, $posting) {
        $data = [
            'username' => $username,
            'posting' => $posting,
        ];
        $url = $this->jsBridgeUrl . '/auth_login';
        $result = $this->postData($url, json_encode($data));
        return $result;
    }

    public function addAccountAuth($username, $activeKey, $authUsername) {
        $data = [
            'username' => $username,
            'active_key' => $activeKey,
            'authorized_username' => $authUsername,
        ];
        $url = $this->jsBridgeUrl . '/add_account_auth';
        $result = $this->postData($url, json_encode($data));
        return $result;
    }

    public function removeAccountAuth($username, $activeKey, $authUsername) {
        $data = [
            'username' => $username,
            'active_key' => $activeKey,
            'authorized_username' => $authUsername,
        ];
        $url = $this->jsBridgeUrl . '/remove_account_auth';
        $result = $this->postData($url, json_encode($data));
        return $result;
    }

    private function postData($url, $jsonData) {
        $options = array(
          'http' =>
            array(
              'header' => "Content-Type: application/json\r\n".
                          "Content-Length: ".strlen($jsonData)."\r\n",
              'method'  => 'POST',
              'content' => $jsonData,
            )
        );
        $context  = stream_context_create($options);
        try {
            $result = file_get_contents($url, false, $context);
            $r = json_decode($result, true);
            return $r;
        } catch (\Exception $e) {
            Log::error('post_data_failed', [$e->getMessage()]);
            return false;
        }
    }
}
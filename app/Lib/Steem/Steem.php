<?php
namespace App\Lib\Steem;
use Log;
use GuzzleHttp\Client;
use BitWasp\Bitcoin\Key\Factory\PrivateKeyFactory;
use BitWasp\Bitcoin\Key\Factory\PublicKeyFactory;
use BitWasp\Bitcoin\Crypto\Random\Random;
use Str;
use BitWasp\Buffertools\Buffer;
use BitWasp\Buffertools\Buffertools;
use BitWasp\Bitcoin\Crypto\Hash;
use BitWasp\Bitcoin\Base58;
use BitWasp\Bitcoin\Bitcoin;
use BitWasp\Bitcoin\Crypto\EcAdapter\Impl\PhpEcc\Key\PublicKey;
use BitWasp\Bitcoin\Crypto\EcAdapter\Impl\PhpEcc\Serializer\Key\PublicKeySerializer;

use Mdanter\Ecc\EccFactory;
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
            Log::warning('getAccountFailed');
            return false;
        }
        if ($response->getStatusCode() === 200) {
            $result = json_decode($response->getBody()->getContents(), true);
            return $result['result'];
        } else {
            Log::warning('getAccount_response_status_code_not_200', [$response]);
            return false;
        }
    }

    public function getDynamicGlobalProperties() {
        $data = $this->dataFactory('condenser_api.get_dynamic_global_properties', []);
        $response = $this->sendData($data);
        if ($response === false) {
            Log::warning('getDynamicGlobalPropertiesFailed');
            return false;
        }
        if ($response->getStatusCode() === 200) {
            $result = json_decode($response->getBody()->getContents(), true);
            return $result['result'];
        } else {
            Log::warning('getDynamicGlobalProperties_response_status_code_not_200', [$response]);
            return false;
        }
    }

    public function getBlock($blockNum) {
        $data = $this->dataFactory('condenser_api.get_block', [$blockNum]);
        $response = $this->sendData($data);
        if ($response === false) {
            Log::warning('getBlockFailed');
            return false;
        }
        if ($response->getStatusCode() === 200) {
            $result = json_decode($response->getBody()->getContents(), true);
            return $result['result'];
        } else {
            Log::warning('getBlockFailed_response_status_code_not_200', [$response]);
            return false;
        }
    }

    public function generatePrivateKeysFromMainPassword($username, $mainPassword) {
        $roles = ['owner', 'active', 'posting', 'memo'];
        $result = [];
        $factory = new PrivateKeyFactory();
        foreach ($roles as $role) {
            $seed = $username.$role.$mainPassword;
            $brainKey = implode(" ", explode("/[\t\n\v\f\r ]+/", trim($seed)));
            $hashSha256 = hash('sha256', $brainKey);
            $privKey = $factory->fromHexUncompressed($hashSha256);
            $result[$role] = $privKey->toWif();
        }
        return $result;
    }

    public function generateRandomPrivateKey() {
        $factory = new PrivateKeyFactory();
        $privKey = $factory->generateUncompressed(new Random());
        return $privKey->toWif();
    }

    public function getPrivateKeyFromWif($wif) {
        $factory = new PrivateKeyFactory();
        $privKey = $factory->fromWif($wif);
        return $privKey;
    }

    public function getPubKeyFromPrivKeyWif($wif) {
        $privKey = $this->getPrivateKeyFromWif($wif);
        $publicKey = $privKey->getPublicKey();
        $pubKeyBuff = $this->doSerialize($publicKey);
        $checkSum = Hash::ripemd160($pubKeyBuff);
        $addy = Buffertools::concat($pubKeyBuff, $checkSum->slice(0, 4));
        $pubdata = Base58::encode($addy);
        $pubKeyStr = 'STM'.$pubdata;
        return $pubKeyStr;
    }

    protected function doSerialize(PublicKey $pubKey) {
        $point = $pubKey->getPoint();
        $prefix = $this->getPubKeyPrefix($pubKey);
        $xBuff = Buffer::hex(gmp_strval($point->getX(), 16), 32);
        $yBuff = Buffer::hex(gmp_strval($point->getY(), 16), 32);
        $data = Buffertools::concat($prefix , $xBuff);
        // steem的compress与btc相反
        if ($pubKey->isCompressed()) {
           $data = Buffertools::concat($data, $yBuff);
        }
        return $data;
    }

    protected function getPubKeyPrefix($pubKey) {
        // steem的compress与btc相反
        return !$pubKey->isCompressed()
            ? Bitcoin::getEcAdapter()->getMath()->isEven($pubKey->getPoint()->getY())
                ? Buffer::hex('02', 1)
                : Buffer::hex('03', 1)
            : Buffer::hex('04', 1);
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

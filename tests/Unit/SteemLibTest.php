<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Lib\Steem\Steem;
use BitWasp\Bitcoin\Key\Factory\PrivateKeyFactory;
use BitWasp\Buffertools\Buffer;

class SteemLibTest extends TestCase
{
    /**
     * getAccount
     *
     * @return void
     */
    public function testGetAccount()
    {
        $steem = new Steem();
        $user = $steem->getAccount('authsteem');
        $this->assertSame('authsteem', $user[0]['name']);
    }

    public function testGetDynamicGlobalProperties()
    {
        $steem = new Steem();
        $dynamicGlobalProperties = $steem->getDynamicGlobalProperties();
        $this->assertTrue(isset($dynamicGlobalProperties['last_irreversible_block_num']));
        $this->assertTrue(isset($dynamicGlobalProperties['time']));
    }

    public function testGetBlock()
    {
        $steem = new Steem();
        $block = $steem->getBlock(1);
        $this->assertSame('0000000109833ce528d5bbfb3f6225b39ee10086', $block['block_id']);
    }

    public function testReadUInt32LE()
    {
        $steem = new Steem();
        $buff1 = '01ec415764849459d51858d7e443c000eb15bcc5';
        $buff1R = $steem->readUInt32LE(Buffer::hex($buff1));
        $this->assertSame('1502905444', $buff1R->getInt());
    }

    public function testPrepareTransaction() {
        $steem = new Steem();
        $tx = [
            'extensions' => [],
            'operations' => [],
        ];
        $preparedTx = $steem->prepareTransaction($tx);
        $this->assertTrue(isset($preparedTx['ref_block_num']));
        $this->assertTrue(isset($preparedTx['ref_block_prefix']));
        $this->assertTrue(isset($preparedTx['expiration']));
    }

    public function testGeneratePrivateKeysFromMainPassword()
    {
        $steem = new Steem();
        $username = 'test';
        $password = 'P5KLzu75NrUWAJgCQDc9hSz7TCYR3KdwEcgmyjJS2JyUHkU4kfaS';
        $re = $steem->generatePrivateKeysFromMainPassword($username, $password);
        $this->assertSame('5K26NutBjFysCe7Ak7NWJdVqowHJLXWNsB2CpvzhjRaxn7XC8m8', $re['owner']);
        $this->assertSame('5K9YKcwDcYwceJga6UWCVSEqUHN28qLh9N2ZP2RdCZjyYY4QxGs', $re['active']);
        $this->assertSame('5JkjMbDGzxyob6YYW5Bf52Q7kqpB9B4GLLHtT7akjsUKBKhjJhy', $re['posting']);
        $this->assertSame('5JSm7ukKeRykouoaVkA2SAvceyQphC3Z1ReWz1LKL17szKqABfv', $re['memo']);
    }

    public function testGenerateRandomPrivateKey()
    {
        $steem = new Steem();
        $p = $steem->generateRandomPrivateKey();
        $factory = new PrivateKeyFactory();
        $privKey = $factory->fromWif($p);
        $this->assertTrue($privKey->isPrivate());
    }

    public function test()
    {
        $wif = '5JPeTYZ2dSVYeYSWYJhr1HWbboXEDCuTe7tWcgWqTrNqBjMM5iJ';
        $pubKey = 'STM6gZXURyXu7g2jEY1RTz4LgxkcdVbm5NLvasbs9pytwpbmvLW3g';
        $steem = new Steem();
        $pubKeyResult = $steem->getPubKeyFromPrivKeyWif($wif);
        $this->assertSame($pubKey, $pubKeyResult);
    }
}

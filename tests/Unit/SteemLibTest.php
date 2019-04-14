<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Lib\Steem\Steem;

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
        $p = $steem->generateRandomPrivateKey('1234567890');
        $this->assertSame('5KL8Xvb5sGL1LZuFQqJGViJzshhboZksehS5DwtJUqVeTMAWsDp', $p);
    }
}
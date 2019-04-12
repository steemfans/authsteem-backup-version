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
}

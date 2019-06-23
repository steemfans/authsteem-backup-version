<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Model\App;

class AppTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $app = new App();
        $app->app_name = 'AuthSteem';
        $app->app_icon = 'https://i.loli.net/2019/06/22/5d0de7b0dd32f71915.png';
        $app->app_desc = '面向国内的Steem登录验证平台';
        $app->app_site = 'https://connect.steemtools.top';
        $app->cb_uri = 'https://connect.steemtools.top/callback';
        $app->test_cb_uri = 'http://laravel.test/callback';
        $app->username = 'authsteem';
        $app->secret = md5(env('APP_KEY'));
        $app->save();
    }
}

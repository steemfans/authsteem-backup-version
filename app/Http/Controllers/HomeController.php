<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Log;
use App\Rules\ScopeChecker;
use App\Model\App as AppTable;
use App\Model\Auth as AuthTable;
use App\Lib\Steem\JsBridge;

class HomeController extends Controller
{
    public function index(Request $request) {
        return response()->view(
            'home/index',
            [],
            200
        );
    }

    public function redirect(Request $request) {
        $data = session('data');
        if (!$data) {
            return redirect()->route('home_index');
        }
        return response()->view(
            'home/redirect',
            $data
        );
    }

    public function callback(Request $request) {
        $data = $request->input();
        var_dump($data);die();
    }
}

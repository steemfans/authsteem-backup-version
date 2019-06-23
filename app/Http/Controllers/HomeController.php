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
}

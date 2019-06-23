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
        Log::info('redirect', [$data]);
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
        $username = isset($data['username']) ? $data['username'] : null;
        $token = isset($data['token']) ? $data['token'] : null;
        $sign = isset($data['sign']) ? $data['sign'] : null;
        $scope = isset($data['scope']) ? $data['scope'] : null;
        if (!$username || !$token || !$sign || !$scope) {
            Log::warning('callback_params_error', [$data]);
            return response()->view(
                'error',
                ['errors' => ['params_error']]
            );
        }
        // auth sign
        $secret = env('AUTHSTEEM_APP_TOKEN');
        $tmpSign = md5($username.$token.$secret);
        if ($tmpSign != $sign) {
            Log::warning('callback_auth_sign_failed', [$data]);
            return response()->view(
                'error',
                ['errors' => ['invalid_input']]
            );
        }
        switch($scope) {
            case 'login':
                $app = AppTable::where('username', $username)->first();
                if (!$app) {
                    return response()->view(
                        'error',
                        ['errors' => ['app_not_register']]
                    );
                }
                session('app', $app);
                return redirect()->route('dashboard_index');
                break;
            case 'posting':
                $app = AppTable::where('username', $username)->first();
                if (!$app) {
                    $app = new AppTable;
                    $app->username = $username;
                    $app->secret = md5(uniqid().env('AUTHSTEEM_APP_TOKEN'));
                    $app->save();
                }
                session('app', $app);
                return redirect()->route('dashboard_index');
                break;
            case 'remove_posting':
                $app = AppTable::where('username', $username)->first();
                $app->delete();
                session('app', null);
                return response()->view(
                    'success',
                    ['success' => ['已成功解绑']]
                );
                break;
            default:
                return response()->view(
                    'error',
                    ['errors' => ['invalid_scope']]
                );
        }
        return redirect()->route('home_index');
    }
}

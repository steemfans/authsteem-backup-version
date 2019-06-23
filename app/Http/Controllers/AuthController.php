<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Log;
use App\Rules\ScopeChecker;
use App\Model\App as AppTable;
use App\Model\Auth as AuthTable;
use App\Lib\Steem\JsBridge;

class AuthController extends Controller
{
    /**
     * @param app_id required
     * @param redirect_uri required
     * @param scope required
     */
    public function auth(Request $request) {
        $data = $request->input();
        $test = isset($data['test']) ? $data['test'] : false;
        $rules = [
            'app_id' => 'required',
            'scope' => ['required', new ScopeChecker()],
        ];
        $messages = [
            'required' => '缺少参数: :attribute',
        ];
        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return response()->view(
                'error',
                ['errors' => $errors]
            );
        }
        // find app
        $app = AppTable::where('username', $data['app_id'])->first();       
        if (!$app) {
            return response()->view(
                'error',
                ['errors' => ['应用不存在']]
            );
        }
        return response()->view(
            'auth/auth',
            [
                'app' => $app,
                'app_id' => $data['app_id'],
                'scope' => $data['scope'],
                'test' => $test,
            ]
        );
    }

    public function authFromPost(Request $request) {
        $data = $request->input();
        $test = $data['test'] == '' ? false : true;
        // get app info
        $app = AppTable::where('username', $data['app_id'])
            ->first();
        if (!$app) {
            return response()->view(
                'error',
                ['errors' => '平台不存在']
            );
        }
        $jsBridge = new JsBridge();
        switch($data['scope']) {
            case 'login':
                // check user exists?
                $user = AuthTable::where('username', $data['username'])
                    ->where('app_id', $data['app_id'])
                    ->first();
                if (!$user) {
                    // redirect to posting auth page
                    return redirect()->route(
                        'auth',
                        [
                            'app_id' => $data['app_id'],
                            'scope' => 'posting'
                        ]
                    )->with('status0', "用户 {$data['username']} 还未对应用平台 {$data['app_id']} 授权。请先授权");
                }
                // auth user posting key
                $result = $jsBridge->authLogin($data['username'], $data['passwd']);
                if ($result === false) {
                    // js bridge error
                    return response()->view(
                        'error',
                        ['errors' => 'js_bridge_error']
                    );
                }
                Log::info('login_auth', $result);
                if ($result['status'] === false) {
                    // login failed
                    switch($result['msg']) {
                        case 'params_error':
                            $err = ['缺少用户名或Posting私钥'];
                            break;
                        case 'login_failed':
                            $err = ['登录验证失败'];
                            break;
                        default:
                            $err = ['异常错误: '.$result['msg']];
                            break;
                    }
                    return response()->view(
                        'error',
                        ['errors' => $err]
                    );
                } else {
                    // login success
                    // update user auth token
                    $token = md5(uniqid());
                    $user->token = $token;
                    $user->save();
                    // redirect to callback
                    $secret = $app->secret;
                    if ($test) {
                        $cbUri = $app->test_cb_uri;
                    } else {
                        $cbUri = $app->cb_uri;
                    }
                    $appUsername = $app->username;
                    $redirectData = [
                        'data' => [
                            'username' => $data['username'],
                            'token' => $token,
                            'sign' => md5($data['username'].$token.$secret),
                            'userinfo' => json_encode($result['msg']),
                            'scope' => $data['scope'],
                        ],
                        'cbUri' => $cbUri,
                    ];
                    return redirect()->route('home_redirect')->with('data', $redirectData);
                }
                break;
            case 'posting':
                $result = $jsBridge->addAccountAuth($data['username'], $data['passwd'], $data['app_id']);
                if ($result === false) {
                    // js bridge error
                    return response()->view(
                        'error',
                        ['errors' => 'js_bridge_error']
                    );
                }
                Log::info('add_account_auth', $result);
                if ($result['status'] === false) {
                    // add account auth failed
                    switch($result['msg']) {
                        case 'params_error':
                            $err = ['缺少用户名或Active私钥'];
                            break;
                        case 'add_account_auth_failed':
                            $err = ['授权失败'];
                            break;
                        default:
                            $err = ['异常错误: '.$result['msg']];
                            break;
                    }
                    return response()->view(
                        'error',
                        ['errors' => $err]
                    );
                } else {
                    // auth success
                    // create user auth
                    $user = new AuthTable();
                    $user->username = $data['username'];
                    $user->app_id = $data['app_id'];
                    $token = md5(uniqid());
                    $user->token = $token;
                    $user->save();
                    // redirect to callback
                    $secret = $app->secret;
                    if ($test) {
                        $cbUri = $app->test_cb_uri;
                    } else {
                        $cbUri = $app->cb_uri;
                    }
                    $appUsername = $app->username;
                    $redirectData = [
                        'data' => [
                            'username' => $data['username'],
                            'token' => $token,
                            'sign' => md5($data['username'].$token.$secret),
                            'result' => json_encode($result['msg']),
                        ],
                        'cbUri' => $cbUri,
                    ];
                    return redirect()->route('home_redirect')->with('data', $redirectData);
                }
                break;
            case 'remove_posting':
                $result = $jsBridge->removeAccountAuth($data['username'], $data['passwd'], $data['app_id']);
                if ($result === false) {
                    // js bridge error
                    return response()->view(
                        'error',
                        ['errors' => 'js_bridge_error']
                    );
                }
                Log::info('remove_account_auth', $result);
                if ($result['status'] === false) {
                    // add account auth failed
                    switch($result['msg']) {
                        case 'params_error':
                            $err = ['缺少用户名或Active私钥'];
                            break;
                        case 'remove_account_auth_failed':
                            $err = ['授权失败'];
                            break;
                        default:
                            $err = ['异常错误: '.$result['msg']];
                            break;
                    }
                    return response()->view(
                        'error',
                        ['errors' => $err]
                    );
                } else {
                    // remove auth success
                    // check user exists?
                    $user = AuthTable::where('username', $data['username'])
                        ->where('app_id', $data['app_id'])
                        ->first();
                    if (!$user) {
                        // redirect to posting auth page
                        return redirect()->route(
                            'auth',
                            [
                                'app_id' => $data['app_id'],
                                'scope' => 'posting'
                            ]
                        )->with('status0', "用户 {$data['username']} 还未对应用平台 {$data['app_id']} 授权。请先授权");
                    }
                    $user->delete();
                    return response()->view(
                        'success',
                        ['success' => ['成功解绑']]
                    );
                }
                break;
            default:
                return response()->view(
                    'error',
                    ['errors' => ['不支持的scope']]
                );
        }
    }
}
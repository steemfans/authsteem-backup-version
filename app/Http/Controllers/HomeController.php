<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Log;
use App\Rules\ScopeChecker;

class HomeController extends Controller
{
    //
    public function index(Request $request) {
        return response()->view(
            'home/index',
            [],
            200
        );
    }

    /**
     * @param app_id required
     * @param redirect_uri required
     * @param scope required
     * @param state required
     */
    public function auth(Request $request) {
        $data = $request->input();
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
        // 处理 authsteem 的登陆请求
        if ($data['app_id'] == 'authsteem') {

        }

        return response()->view(
            'home/auth',
            []
        );
    }
}

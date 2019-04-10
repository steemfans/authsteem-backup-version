<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Log;

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
     * @param client_id required
     * @param redirect_uri required
     * @param scope required
     * @param state required
     */
    public function auth(Request $request) {
        $data = $request->input();
        $rules = [
            'client_id' => 'required',
            'scope' => 'required',
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
        $defaultScopes = ['posting', 'active', 'owner', 'login'];
        $tmpScope = explode(',', $data['scope']);
        foreach($tmpScope as $k => $v) {
            if (!in_array($v, $defaultScopes)) {
                unset($tmpScope[$k]);
            }
        }
        if (count($tmpScope) == 0) {
            $errors = ['scope有误'];
            return response()->view(
                'error',
                ['errors' => $errors]
            );
        }

        return response()->view(
            'home/auth',
            []
        );
    }
}

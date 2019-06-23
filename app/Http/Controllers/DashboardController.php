<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\App as AppTable;
use App\Model\Auth as AuthTable;

class DashboardController extends Controller
{
    public function index(Request $request) {
        $app = session('app');
        if (!$app) {
            return redirect()->route('home_index');
        }
        return response()->view(
            'dashboard/index',
            $app,
            200
        );
    }

    public function indexSave(Request $request) {
        $data = $request->input();
        $app = session('app');
        if (!$app) {
            return redirect()->route('home_index');
        }
        unset($data['_token']);
        $app->fill($data);
        $app->save();
        session(['app' => $app]);
        return redirect()->route('dashboard_index')->with('status1', '更新成功');
    }

    public function logout(Request $request) {
        session(['app' => null]);
        return redirect()->route('home_index');
    }
}

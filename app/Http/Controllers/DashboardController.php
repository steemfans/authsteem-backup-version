<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\App as AppTable;
use App\Model\Auth as AuthTable;

class DashboardController extends Controller
{
    public function index(Request $request) {
        $app = session('app');
        return response()->view(
            'dashboard/index',
            $app,
            200
        );
    }

    public function indexSave(Request $request) {
        $data = $request->input();
        $app = session('app');
        unset($data['_token']);
        $app->fill($data);
        return redirect()->route('dashboard_index')->with('status1', '更新成功');
    }

    public function logout(Request $request) {
        session(['app' => null]);
        return redirect()->route('home_index');
    }
}

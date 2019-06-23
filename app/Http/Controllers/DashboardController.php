<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}

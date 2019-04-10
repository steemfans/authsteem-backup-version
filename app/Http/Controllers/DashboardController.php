<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request) {
        return response()->view(
            'dashboard/index',
            [],
            200
        );
    }

    public function create(Request $request) {
        return response()->view(
            'dashboard/app/create',
            [],
            200
        );
    }
}

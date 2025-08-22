<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function AdminDashboard()
    {
        return view('admin.dashboard.index');
    }
}

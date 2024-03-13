<?php

namespace App\Http\Controllers\WEB\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Hash;

// namespace App\Http\Controllers\Auth;


class TenantDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:tenant');
    }
    public function dashboard()
    {
        // dd(Auth::guard('tenant')->user());
        return view('tenant.dashboard');
    }
}

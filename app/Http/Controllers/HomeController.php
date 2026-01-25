<?php

namespace App\Http\Controllers;

use App\Models\SystemSetting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     */
    public function index()
    {
        $systemSetting = SystemSetting::first();
        return view('welcome', compact('systemSetting'));
    }
}

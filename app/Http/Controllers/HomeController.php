<?php

namespace App\Http\Controllers;

use App\Models\SliderImage;
use App\Models\SystemSetting;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     */
    public function index()
    {
        $systemSetting = SystemSetting::first();

        $sliders = SliderImage::where('status', 'active')
            ->latest()
            ->take(3)
            ->get();

        return view('welcome', compact('systemSetting', 'sliders'));
    }
}

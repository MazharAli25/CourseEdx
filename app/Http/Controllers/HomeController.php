<?php

namespace App\Http\Controllers;

use App\Mail\ContactSuperMail;
use App\Mail\ContactUserMail;
use App\Models\PrivacyPolicy;
use App\Models\SliderImage;
use App\Models\SystemSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     */
    public function index()
    {
        $systemSetting = SystemSetting::first();

        $sliders = SliderImage::where('status', 'active')
            ->orderBy('id', 'asc')
            ->take(3)
            ->get();

        return view('welcome', compact('systemSetting', 'sliders'));
    }

    public function contactSubmit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
        ]);

        //  Send email to SuperAdmin
        Mail::to($validated['email'])->send(new ContactUserMail($validated));
        Mail::to(config('mail.super_mail'))->send(new ContactSuperMail($validated));
        


        return redirect()->back()->with('success', 'Your message has been sent successfully!');
    }

    public function privacyPolicy(){
        $policies= PrivacyPolicy::where(['status'=> 'active', 'type'=>'pp'])->get();
        $latestUpdate = PrivacyPolicy::where(['status'=> 'active', 'type'=>'pp'])->latest('updated_at')->first();
        return view('privacyPolicy', compact(['policies', 'latestUpdate']));
    }

    public function termsConditions(){
        $tcs= PrivacyPolicy::where(['status'=> 'active', 'type'=>'tc'])->get();
        $latestUpdate = PrivacyPolicy::where(['status'=> 'active', 'type'=>'tc'])->latest('updated_at')->first();
        return view('termsConditions', compact(['tcs', 'latestUpdate']));
    }
}

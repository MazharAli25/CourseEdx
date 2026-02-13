<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Auth.register');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:student,teacher',
        ]);

        User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'role' => $validatedData['role'],
        ]);
        event(new Registered(User::where('email', $validatedData['email'])->first()));

        return redirect()->route('login')->with('success', 'Registration successful. Please log in.');
    }

    /**
     * Display the specified resource.
     */
    public function show(AuthenticationController $authenticationController)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AuthenticationController $authenticationController)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AuthenticationController $authenticationController)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AuthenticationController $authenticationController)
    {
        //
    }

    private function redirectToDashboard()
    {
        $user = Auth::user();

        return match ($user->role) {
            'super-admin' => redirect()->route('super.dashboard'),
            'student' => redirect()->route('student.dashboard'),
            'teacher' => redirect()->route('teacher.dashboard'),
            default => redirect('/'),
        };
    }

    public function login()
    {
        if (Auth::check()) {
            return $this->redirectToDashboard()->with('error', 'You are already logged in.');
        }

        return view('Auth.login');
    }

    public function loginSubmit(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();
            if (! $user->hasVerifiedEmail()) {
                
                return redirect()->route('verification.notice')
                ->with('error', 'Please verify your email before logging in.');
                Auth::logout();
            }
            if ($user->status === 'disabled') {
                Auth::logout();

                return back()->with('error', 'Your account has been disabled. Please contact the administrator.');

            } else {
                if ($user->role === 'super-admin') {
                    return redirect()->route('super.dashboard');
                }
                if ($user->role === 'student') {
                    return redirect()->route('student.dashboard');
                }

                if ($user->role === 'teacher') {
                    return redirect()->route('teacher.dashboard');
                }
            }
        }

        return back()->with('error', 'Invalid email or password');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}

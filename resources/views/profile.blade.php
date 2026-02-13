@extends('layouts.user')
@section('page-title', 'Profile')

@section('main-content')
    <div class="flex justify-center py-10 px-4 border-t border-slate-200">
        <div class="w-full max-w-4xl space-y-8">

            <!-- Profile Header -->
            <section class="bg-white rounded-xl shadow-sm p-6 flex items-center gap-6">
                <div class="relative">
                    <img src="{{ asset(auth()->user()->image ?? 'images/default-avater.jfif') }}"
                        class="w-28 h-28 rounded-full border border-slate-300 object-cover" />
                    <span class="absolute bottom-1 right-1 bg-green-500 w-4 h-4 rounded-full border border-white"></span>
                </div>

                <div class="flex-1">
                    <h2 class="text-2xl font-semibold">{{ auth()->user()->name }}</h2>
                    <p class="text-sm text-slate-500">{{ auth()->user()->email }}</p>
                    <span class="inline-block mt-2 text-xs bg-slate-100 px-3 py-1 rounded-lg">
                        {{ auth()->user()->role }}
                    </span>
                </div>
            </section>

            <!-- Account Stats -->
            <section class="bg-white rounded-xl shadow-sm p-6 grid grid-cols-3 text-center text-sm gap-6">
                <div>
                    <p class="font-semibold text-lg">2026</p>
                    <p class="text-slate-500">Member Since</p>
                </div>
                <div>
                    <p class="font-semibold text-lg">{{ ucfirst(auth()->user()->status) }}</p>
                    <p class="text-slate-500">Account Status</p>
                </div>
                <div>
                    <p class="font-semibold text-lg">
                        {{ auth()->user()->email_verified_at ? 'Verified' : 'Unverified' }}
                    </p>
                    <p class="text-slate-500">Email Verified</p>
                </div>
            </section>

            <!-- Personal Information -->
            <section class="bg-white rounded-xl shadow-sm p-6 space-y-3">
                <h3 class="text-base font-semibold border-b pb-2 mb-4">Personal Information</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-slate-500 text-sm">Full Name</p>
                        <p class="font-medium">{{ auth()->user()->name }}</p>
                    </div>
                    <div>
                        <p class="text-slate-500 text-sm">Email</p>
                        <p class="font-medium">{{ auth()->user()->email }}</p>
                    </div>
                    <div>
                        <p class="text-slate-500 text-sm">Role</p>
                        <p class="font-medium">{{ auth()->user()->role }}</p>
                    </div>
                    <div>
                        <p class="text-slate-500 text-sm">Account Status</p>
                        <p class="font-medium">{{ ucfirst(auth()->user()->status) }}</p>
                    </div>
                </div>
            </section>

            <!-- Optional Danger Note -->
            <section class="bg-red-50 border border-red-200 rounded-xl p-6">
                <h3 class="text-red-600 font-semibold mb-2">⚠ Danger Zone</h3>
                <p class="text-sm text-slate-700">
                    Deleting your account is permanent and cannot be undone. All your data will be removed.
                </p>
            </section>

        </div>
    </div>

@endsection

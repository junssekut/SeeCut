<?php

use App\Models\User;
use App\Livewire\Forms\LoginForm; // This might not be needed if not using a dedicated Form Object
use Illuminate\Support\Facades\Session;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash; // Import Hash facade
use Illuminate\Support\Facades\Auth; // Import Auth facade

use function Livewire\Volt\form;
use function Livewire\Volt\layout;
use function Livewire\Volt\state;
use function Livewire\Volt\rules;
use function Livewire\Volt\action;
use function Livewire\Volt\mount;

layout('layouts.app');

state([
    'login_field' => '',
    'password' => '',
]);

mount(function () {
    // Check if regular user (non-vendor) is already logged in
    if (Auth::check() && Auth::user()->profile?->role !== 'vendor') {
        // Regular user trying to access vendor login - show access denied
        return response()->view(
            'errors.vendor-access-denied',
            [
                'previousUrl' => url()->previous(),
            ],
            403,
        );
    }

    // If vendor is already logged in, redirect to dashboard
    if (Auth::check() && Auth::user()->profile?->role === 'vendor') {
        return redirect()->route('vendor.reservation');
    }
});

$execLogin = function () {
    // Validate login field and password
    $this->validate(
        [
            'login_field' => 'required|string',
            'password' => 'required|string',
        ],
        [
            'login_field.required' => 'Email atau Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ],
    );

    // Find user by email or username
    $user = User::where('email', $this->login_field)->orWhere('username', $this->login_field)->first();

    if (!$user) {
        throw ValidationException::withMessages([
            'login_field' => 'Email atau Username tidak ditemukan.',
        ]);
    }

    if (!Hash::check($this->password, $user->password)) {
        throw ValidationException::withMessages([
            'password' => 'Password salah.',
        ]);
    }

    // Check if user is a customer trying to login as vendor
    if (!$user->profile || $user->profile->role !== 'vendor') {
        throw ValidationException::withMessages([
            'role_error' => 'Anda terdaftar sebagai customer. Silakan masuk melalui halaman login customer.',
        ]);
    }

    Auth::login($user, remember: true);
    Session::regenerate();

    $this->redirect(route('vendor.reservation'));
};
?>

{{-- Temporarily commented out to rule out issues from this file --}}
{{-- @vite(['resources/js/pages/login.js']) --}}

<div>
    <div class="flex justify-center items-center h-screen bg-[linear-gradient(to_bottom,_#284123,_#0C0C0C)]">
        <div
            class="container bg-Seasalt w-[1000px] max-w-[100vw] h-[600px] relative overflow-x-hidden rounded-none sm:rounded-xl">
            <div class="forms-container relative w-[50%] text-center">
                <div
                    class="form-control signin-form absolute w-[100%] flex justify-center flex-col h-[600px] transition duration-300 ease-in opacity-1 z-1 left-[200%]">
                    {{-- Corrected x-data binding: removed 'form.' prefix --}}
                    {{-- Added console.log to check Alpine.js initialization --}}
                    <form wire:submit.prevent="execLogin" class="flex flex-col mx-[50px]" x-data="{ login_field: @entangle('login_field').defer, password: @entangle('password').defer, init() { console.log('Alpine.js x-data initialized for login form'); } }">
                        {{-- INTRODUCTION --}}
                        <div class="text-Dark-Olive text-5xl font-Kuunari font-bold text-center sm:text-start">
                            <h1>MASUK</h1>
                        </div>
                        <div
                            class="text-[#000000] text-sm font-Poppins text-center sm:text-start justify-center pt-1 mb-5">
                            <p>Yuk, mulai terima bookingan online sekarang!</p>
                        </div>

                        {{-- USERNAME/EMAIL INPUT FIELD --}}
                        <div x-data="{ isFocused: false }" x-init="$nextTick(() => {
                            if ($el.querySelector('#login-field') === document.activeElement) {
                                isFocused = true;
                            }
                        })"
                            :class="{
                                'bg-Dark-Olive': isFocused || login_field,
                                'bg-Dark-Olive/60': !isFocused && !login_field
                            }"
                            class="mb-4 text-Dark-Olive flex flex-row py-4 border-none rounded-md items-center cursor-text
               shadow-sm has-[:focus]:shadow-md transition-all duration-200">
                            {{-- Label: Clicking this will focus the input, but cursor remains text --}}
                            <label for="login-field"
                                class="flex flex-1 flex-wrap border-none items-center w-full h-full cursor-text">
                                <div class="w-4 h-4 mx-4 text-center">
                                    {{-- User Icon Component --}}
                                    <x-svg.user-icon class="text-Seasalt" />
                                </div>

                                <input wire:model="login_field" id="login-field"
                                    class="peer flex-1 p-0 border-none bg-transparent placeholder-Seasalt text-Seasalt font-Poppins text-sm focus:outline-none focus:ring-0"
                                    type="text" name="login_field" required autofocus autocomplete="username"
                                    placeholder="Email atau Username" x-model="login_field" @focus="isFocused = true"
                                    @blur="isFocused = false" />
                            </label>
                        </div>

                        {{-- LOGIN FIELD ERROR --}}
                        <x-input-error :messages="$errors->get('login_field')" class="mb-4 text-Seasalt" />

                        {{-- PASSWORD INPUT FIELD --}}
                        <div x-data="{ isFocused: false }"
                            :class="{
                                'bg-Dark-Olive': isFocused || password,
                                'bg-Dark-Olive/60': !isFocused && !password
                            }"
                            class="mb-4 text-Seasalt flex justify-between flex-wrap py-4 border-none rounded-md items-center cursor-text
               shadow-sm has-[:focus]:shadow-md transition-all duration-200">
                            <label for="passwordlogin"
                                class="flex flex-1 flex-wrap border-none items-center w-full h-full cursor-text">
                                <div class="w-4 h-4 mx-4 flex items-center justify-center overflow-hidden">
                                    {{-- Lock Icon Component --}}
                                    <x-svg.lock-icon class="text-Seasalt" />
                                </div>

                                <input wire:model="password" id="passwordlogin"
                                    class="peer flex-1 p-0 border-none bg-transparent placeholder-Seasalt text-Seasalt font-Poppins text-sm focus:outline-none focus:ring-0"
                                    type="password" name="password" required autocomplete="current-password"
                                    placeholder="Password" x-model="password" @focus="isFocused = true"
                                    @blur="isFocused = false" />
                            </label>
                            <div id="passwordToggle" class="w-4 h-4 mx-4 cursor-pointer">
                                <x-svg.eye-icon />
                            </div>
                        </div>

                        {{-- PASSWORD ERROR --}}
                        <x-input-error :messages="$errors->get('password')" class="mb-4 text-Seasalt" />

                        {{-- ROLE ERROR MESSAGE --}}
                        @error('role_error')
                            <div
                                class="mt-4 bg-gradient-to-br from-amber-50 via-yellow-50 to-orange-50 border border-amber-200 rounded-xl p-5 shadow-xl backdrop-blur-sm">
                                <div class="flex items-start space-x-4">
                                    <div class="flex-shrink-0 bg-amber-100 rounded-full p-2">
                                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-lg font-bold text-amber-900 font-Kuunari mb-2">Oops! Akun Salah</h3>
                                        <p class="text-sm text-amber-800 font-Poppins leading-relaxed mb-4">
                                            {{ $message }}</p>
                                        <div class="flex flex-col sm:flex-row gap-3">
                                            <a href="{{ route('login') }}"
                                                class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-amber-600 to-orange-600 hover:from-amber-700 hover:to-orange-700 text-white text-sm font-bold rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 font-Poppins">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                                </svg>
                                                Masuk Sebagai Customer
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @enderror

                        {{-- LOGIN BUTTON --}}
                        <div class="flex justify-center">
                            <button type="submit" :disabled="!login_field || !password" {{-- Button is disabled if login_field OR password is empty --}}
                                class="mt-5 bg-Dark-Olive text-Seasalt w-full text-sm py-4 rounded-md font-bold
                   transition duration-300 ease-in-out shadow-lg font-Poppins
                   hover:text-white hover:bg-Dark-Olive/60 focus:outline-2
                   disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:bg-Dark-Olive disabled:hover:text-Seasalt">
                                MASUK SEKARANG!
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="intros-container relative left-[50%] w-[50%] text-center">
                <div
                    class="intro-control signin-intro absolute w-[100%] flex justify-center flex-col h-[600px] transition duration-300 ease-in opacity-[1] z-[2]">
                    <div
                        class="absolute inset-1/2 -translate-x-1/2 -translate-y-1/2 w-[98%] h-[98%] bg-Dark-Olive/60 bg-no-repeat bg-center bg-contain z-0 rounded-xl shadow-xl">
                    </div>
                    <img src="{{ asset('assets/images/login-vendor.jpg') }}"
                        class="absolute inset-1/2 -translate-x-1/2 -translate-y-1/2 w-[98%] h-[98%] object-cover -z-10 rounded-xl shadow-xl"
                        alt="Background" />
                </div>

            </div>
        </div>
    </div>
</div>

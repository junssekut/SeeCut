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

layout('layouts.app');

state([
    'username' => '',
    'password' => '',
]);

$execLogin = function () {
    // dd('test'); // This will now be hit if the function is called
    $data = [
        'username' => $this->username,
        'password' => $this->password,
    ];

    $rules = [
        'username' => ['required', 'string'],
        'password' => ['required', 'string'],
    ];

    Validator::make($data, $rules)->validate();

    $user = User::where('username', $this->username)->first();

    if (!$user || !Hash::check($this->password, $user->password)) {
        throw ValidationException::withMessages([
            'username' => __('auth.failed'),
        ]);
    }

    Auth::login($user, remember: true);

    Session::regenerate();

    $this->redirect(route('home', absolute: false), navigate: true);
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
                    <form wire:submit.prevent="execLogin" class="flex flex-col mx-[50px]" x-data="{ username: @entangle('username').defer, password: @entangle('password').defer, init() { console.log('Alpine.js x-data initialized for login form'); } }">
                        {{-- INTRODUCTION --}}
                        <div class="text-Dark-Olive text-5xl font-Kuunari font-bold text-center sm:text-start">
                            <h1>MASUK</h1>
                        </div>
                        <div
                            class="text-[#000000] text-sm font-Poppins text-center sm:text-start justify-center pt-1 mb-5">
                            <p>Yuk, mulai terima bookingan online sekarang!</p>
                        </div>

                        {{-- USERNAME INPUT FIELD --}}
                        <div x-data="{ isFocused: false }" x-init="$nextTick(() => {
                            if ($el.querySelector('#username') === document.activeElement) {
                                isFocused = true;
                            }
                        })"
                            :class="{
                                'bg-Dark-Olive': isFocused || username,
                                'bg-Dark-Olive/60': !isFocused && !username
                            }"
                            class="mb-4 text-Dark-Olive flex flex-row py-4 border-none rounded-md items-center cursor-text
               shadow-sm has-[:focus]:shadow-md transition-all duration-200">
                            {{-- Label: Clicking this will focus the input, but cursor remains text --}}
                            <label for="username"
                                class="flex flex-1 flex-wrap border-none items-center w-full h-full cursor-text">
                                <div class="w-4 h-4 mx-4 text-center">
                                    {{-- User Icon Component --}}
                                    <x-svg.user-icon class="text-Seasalt" />
                                </div>

                                {{-- wire:model and x-model are already correct, binding directly to 'username' --}}
                                <input wire:model="username" id="username"
                                    class="peer flex-1 p-0 border-none bg-transparent placeholder-Seasalt text-Seasalt font-Poppins text-sm focus:outline-none focus:ring-0"
                                    type="username" name="username" required autofocus autocomplete="username"
                                    placeholder="Username" x-model="username" @focus="isFocused = true"
                                    @blur="isFocused = false" />
                                <x-input-error :messages="$errors->get('username')" class="mt-2 text-Seasalt" />
                            </label>
                        </div>

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

                                {{-- wire:model and x-model are already correct, binding directly to 'password' --}}
                                <input wire:model="password" id="passwordlogin"
                                    class="peer flex-1 p-0 border-none bg-transparent placeholder-Seasalt text-Seasalt font-Poppins text-sm focus:outline-none focus:ring-0"
                                    type="password" name="password" required autocomplete="current-password"
                                    placeholder="Password" x-model="password" @focus="isFocused = true"
                                    @blur="isFocused = false" />

                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </label>
                            <div id="passwordToggle" class="w-4 h-4 mx-4 cursor-pointer">
                                <x-svg.eye-icon />
                            </div>
                        </div>

                        {{-- LOGIN BUTTON --}}
                        <div class="flex justify-center">
                            <button type="submit" :disabled="!username || !password" {{-- Button is disabled if either username OR password is empty --}}
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

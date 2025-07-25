<?php

use App\Models\User;
use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Validator;

use function Livewire\Volt\form;
use function Livewire\Volt\layout;
use function Livewire\Volt\state;
use function Livewire\Volt\rules;

layout('layouts.app');

// form(LoginForm::class);

state([
    'login_field' => '',
    'password' => '',
    'password_confirmation' => '',
    'role_id' => 1,
]);

$login = function () {
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

    // Check if user is a vendor trying to login as customer
    if ($user->profile && $user->profile->role === 'vendor') {
        throw ValidationException::withMessages([
            'role_error' => 'Anda terdaftar sebagai vendor. Silakan masuk melalui halaman login vendor.',
        ]);
    }

    Auth::login($user, remember: true);
    Session::regenerate();

    $this->redirect(route('home', absolute: false), navigate: true);
};

$register = function () {
    $data = [
        'username' => $this->username,
        'email' => $this->email,
        'password' => $this->password,
        'password_confirmation' => $this->password_confirmation,
        'role_id' => $this->role_id,
    ];

    $rules = [
        'username' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
        'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        'role_id' => ['required', 'exists:user_roles,id'],
    ];

    $validated = Validator::make($data, $rules)->validate();

    $validated['password'] = Hash::make($validated['password']);

    event(new Registered(($user = User::create($validated))));

    Auth::login($user);

    $this->redirect(route('home', absolute: false), navigate: true);
};
?>

@push('styles')
    @vite(['resources/js/pages/login.js'])
@endpush

<div>
    <div class="flex justify-center items-center h-screen bg-black">
        <img src="{{ asset('assets/images/Wave-Register.png') }}"
            class="absolute inset-0 w-full h-full object-cover z-0 opacity-20" alt="Background" />

        <!-- Back Button -->
        <button onclick="history.back()"
            class="absolute top-6 left-24 z-50 flex items-center justify-center w-12 h-12 bg-[#6B592E]/80 hover:bg-[#6B592E] text-white rounded-full transition-all duration-200 shadow-lg hover:shadow-xl backdrop-blur-sm">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </button>

        <div
            class="container bg-Seasalt w-[1000px] max-w-[100vw] h-[600px] relative overflow-x-hidden rounded-none sm:rounded-xl">
            <div class="forms-container relative w-[50%] text-center">
                <div
                    class="form-control signin-form absolute w-[100%] flex justify-center flex-col h-[600px] transition duration-300 ease-in opacity-1 z-2 left-[0%]">
                    <form wire:submit="login" class="flex flex-col mx-[50px]" x-data="{ login_field: @entangle('login_field').defer, password: @entangle('password').defer }">
                        {{-- INTRODUCTION --}}
                        <div class="text-[#6B592E] text-5xl font-Kuunari font-bold text-center sm:text-start">
                            <h1>MASUK</h1>
                        </div>
                        <div
                            class="text-[#000000] text-sm font-Poppins text-center sm:text-start justify-center pt-1 mb-5">
                            <p>Yuk mulai gaya barumu di sini!</p>
                        </div>

                        {{-- USERNAME/EMAIL INPUT FIELD --}}
                        <div x-data="{ isFocused: false }" x-init="$nextTick(() => {
                            if ($el.querySelector('#login-field') === document.activeElement) {
                                isFocused = true;
                            }
                        })"
                            :class="{
                                'bg-[#E9BF80]': isFocused || login_field,
                                'bg-[#E9BF80]/60': !isFocused && !login_field
                            }"
                            class="mb-4 text-[#6B592E] flex flex-row py-4 border-none rounded-md items-center cursor-text
               shadow-sm has-[:focus]:shadow-md transition-all duration-200">
                            {{-- Label: Clicking this will focus the input, but cursor remains text --}}
                            <label for="login-field"
                                class="flex flex-1 flex-wrap border-none items-center w-full h-full cursor-text">
                                <div class="w-4 h-4 mx-4 text-center">
                                    {{-- User Icon Component --}}
                                    <x-svg.user-icon />
                                </div>

                                <input wire:model="login_field" id="login-field"
                                    class="peer flex-1 p-0 border-none bg-transparent placeholder-[#6B592E] font-Poppins text-sm focus:outline-none focus:ring-0"
                                    type="text" name="login_field" required autofocus autocomplete="username"
                                    placeholder="Email atau Username" x-model="login_field" @focus="isFocused = true"
                                    @blur="isFocused = false" />
                            </label>
                        </div>

                        {{-- LOGIN FIELD ERROR --}}
                        <x-input-error :messages="$errors->get('login_field')" class="mb-4" />

                        {{-- PASSWORD INPUT FIELD --}}
                        <div x-data="{ isFocused: false }"
                            :class="{
                                'bg-[#E9BF80]': isFocused || password,
                                'bg-[#E9BF80]/60': !isFocused && !password
                            }"
                            class="mb-4 text-[#6B592E] flex justify-between flex-wrap py-4 border-none rounded-md items-center cursor-text
               shadow-sm has-[:focus]:shadow-md transition-all duration-200">
                            <label for="passwordlogin"
                                class="flex flex-1 flex-wrap border-none items-center w-full h-full cursor-text">
                                <div class="w-4 h-4 mx-4 flex items-center justify-center overflow-hidden">
                                    {{-- Lock Icon Component --}}
                                    <x-svg.lock-icon />
                                </div>

                                <input wire:model="password" id="passwordlogin"
                                    class="peer flex-1 p-0 border-none bg-transparent placeholder-[#6B592E] font-Poppins text-sm focus:outline-none focus:ring-0"
                                    type="password" name="password" required autocomplete="current-password"
                                    placeholder="Password" x-model="password" @focus="isFocused = true"
                                    @blur="isFocused = false" />
                            </label>
                            <div id="passwordToggle" class="w-4 h-4 mx-4 cursor-pointer">
                                <x-svg.eye-icon />
                            </div>
                        </div>

                        {{-- PASSWORD ERROR --}}
                        <x-input-error :messages="$errors->get('password')" class="mb-4" />

                        {{-- ROLE ERROR MESSAGE --}}
                        @error('role_error')
                            <div
                                class="mt-4 bg-gradient-to-br from-red-50 via-orange-50 to-yellow-50 border border-red-200 rounded-xl p-5 shadow-xl backdrop-blur-sm">
                                <div class="flex items-start space-x-4">
                                    <div class="flex-shrink-0 bg-red-100 rounded-full p-2">
                                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-lg font-bold text-red-900 font-Kuunari mb-2">Oops! Akun Salah</h3>
                                        <p class="text-sm text-red-800 font-Poppins leading-relaxed mb-4">
                                            {{ $message }}</p>
                                        <div class="flex flex-col sm:flex-row gap-3">
                                            <a href="{{ route('vendor.login') }}"
                                                class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-red-600 to-orange-600 hover:from-red-700 hover:to-orange-700 text-white text-sm font-bold rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 font-Poppins">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                                </svg>
                                                Masuk Sebagai Vendor
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @enderror

                        {{-- LOGIN BUTTON --}}
                        <div class="flex justify-center">
                            <button type="submit" :disabled="!login_field || !password" {{-- Button is disabled if login_field OR password is empty --}}
                                class="mt-5 bg-[#6B592E] text-[#FFEDB7] w-full text-sm py-4 rounded-md font-bold
                   transition duration-300 ease-in-out shadow-lg font-Poppins
                   hover:text-white hover:bg-[#B5964D] focus:outline-2
                   disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:bg-[#6B592E] disabled:hover:text-[#FFEDB7]">
                                Masuk
                            </button>
                        </div>
                    </form>
                </div>
                <div
                    class="form-control signup-form absolute w-[100%] flex justify-center flex-col h-[600px] transition duration-300 ease-in opacity-0 z-1 left-[100%]">
                    <form wire:submit="register" class="flex flex-col mx-[50px]">
                        {{-- INTRODUCTION --}}
                        <div class="text-[#6B592E] text-5xl font-Kuunari font-bold text-center sm:text-start">
                            <h1>DAFTAR</h1>
                        </div>
                        <div
                            class="text-[#000000] text-sm font-Poppins text-center sm:text-start justify-center pt-1 mb-5">
                            <p>Ayo Mulai Pertualangan Cukurmu!</p>
                        </div>
                        {{-- USERNAME --}}
                        <div
                            class="mb-4 text-[#6B592E] flex flex-row py-4 border-none bg-[#E9BF80] rounded-md items-center cursor-text">
                            <label for="username" class=" flex flex-1 flex-wrap border-none items-center">
                                <div class="w-4 h-4 mx-4 text-center ">
                                    <!-- SVG icon -->
                                    <svg version="1.0" xmlns="http://www.w3.org/2000/svg" class="w-full h-full"
                                        viewBox="0 0 1181.000000 1181.000000" preserveAspectRatio="xMidYMid meet">

                                        <g transform="translate(0.000000,1181.000000) scale(0.100000,-0.100000)"
                                            fill="#6B592E" stroke="none">
                                            <path d="M5615 11793 c-193 -24 -336 -50 -460 -83 -646 -176 -1202 -576 -1572
-1130 -322 -482 -479 -1035 -460 -1615 20 -581 204 -1105 554 -1574 114 -152
382 -420 534 -534 391 -292 803 -460 1304 -533 148 -22 532 -25 675 -5 244 33
504 99 695 178 652 266 1169 751 1465 1376 178 377 261 751 261 1177 0 317
-41 580 -136 866 -135 406 -336 739 -630 1043 -247 255 -475 420 -785 570
-299 144 -577 223 -912 260 -89 10 -463 13 -533 4z" />
                                            <path d="M5675 5504 c-1192 -59 -2255 -478 -3135 -1237 -159 -137 -413 -389
-540 -537 -99 -115 -294 -371 -377 -495 -451 -677 -735 -1451 -828 -2260 -21
-184 -38 -495 -32 -592 9 -149 88 -273 216 -336 l66 -32 4825 0 4825 0 58 29
c78 40 144 108 181 186 30 63 31 71 34 220 8 351 -53 823 -159 1230 -319 1226
-1092 2302 -2151 2994 -716 467 -1523 744 -2378 816 -130 10 -499 19 -605 14z" />
                                        </g>
                                    </svg>
                                </div>

                                <input wire:model="username" id="username"
                                    class="flex-1 p-0 border-none bg-[#E9BF80] placeholder-[#6B592E] font-Poppins text-sm focus:outline-none focus:ring-0"
                                    type="username" name="username" required autofocus autocomplete="username"
                                    placeholder="Masukkan username anda" />
                                <x-input-error :messages="$errors->get('username')" class="mt-2" />
                                {{-- <input type="text" id="username" name="username"
                                        placeholder="Masukkan username anda" required
                                        class="flex-1 p-0 border-none bg-[#E9BF80] placeholder-[#6B592E] font-Poppins text-sm focus:outline-none focus:ring-0" /> --}}
                            </label>
                        </div>

                        {{-- EMAIL --}}
                        <div
                            class="mb-4 text-[#6B592E] flex flex-row py-4 border-none bg-[#E9BF80] rounded-md items-center cursor-text">
                            <label for="email" class=" flex flex-1 flex-wrap border-none items-center">
                                <div class="w-4 h-4 mx-4">
                                    <!-- SVG icon -->
                                    <svg version="1.0" xmlns="http://www.w3.org/2000/svg" class="w-full h-full"
                                        viewBox="0 0 1181.000000 1181.000000" preserveAspectRatio="xMidYMid meet">

                                        <g transform="translate(0.000000,1181.000000) scale(0.100000,-0.100000)"
                                            fill="#6B592E" stroke="none">
                                            <path d="M1205 9713 c-116 -28 -406 -153 -445 -193 -3 -3 -23 -17 -46 -32 -63
-40 -208 -182 -262 -256 -116 -157 -173 -277 -222 -472 -5 -19 -18 -99 -30
-177 -21 -142 -21 -150 -20 -2739 0 -1590 4 -2623 10 -2663 12 -85 47 -180
110 -297 67 -127 115 -191 234 -310 163 -164 332 -259 561 -318 194 -49 -153
-46 4743 -46 3126 0 4576 -4 4628 -11 101 -14 194 6 369 79 284 118 515 340
666 640 65 127 103 414 88 647 -4 55 -8 1167 -9 2470 -1 1304 -5 2424 -10
2490 -9 136 -28 238 -60 320 -4 11 -16 43 -25 70 -10 28 -21 55 -26 60 -4 6
-22 40 -39 75 -60 123 -115 195 -245 325 -132 132 -252 223 -375 285 -36 18
-74 38 -85 44 -14 8 -1349 11 -4755 12 -2604 1 -4744 0 -4755 -3z m8955 -618
c0 -2 -80 -60 -177 -128 -98 -68 -275 -193 -393 -276 -118 -84 -325 -229 -459
-324 -134 -95 -307 -217 -385 -272 -77 -56 -229 -162 -336 -237 -107 -75 -310
-218 -450 -317 -140 -99 -315 -222 -388 -273 -73 -51 -253 -178 -401 -283
-148 -104 -386 -273 -531 -375 -144 -102 -360 -254 -479 -339 -119 -84 -230
-160 -248 -169 -32 -15 -32 -15 -105 35 -157 109 -260 179 -423 289 -93 64
-258 176 -365 249 -107 74 -244 168 -305 209 -60 41 -202 137 -315 215 -113
77 -268 183 -345 235 -188 128 -361 246 -470 321 -106 73 -321 220 -530 362
-356 242 -559 381 -695 474 -80 55 -215 147 -300 205 -466 317 -544 372 -548
382 -3 9 1020 13 4275 15 2353 1 4299 3 4326 5 26 1 47 0 47 -3z" />
                                        </g>
                                    </svg>

                                </div>

                                <input wire:model="email" id="email"
                                    class="flex-1 p-0 border-none bg-[#E9BF80] placeholder-[#6B592E] font-Poppins text-sm focus:outline-none focus:ring-0"
                                    type="email" name="email" required autocomplete="username"
                                    placeholder="Masukkan email anda" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />

                                {{-- <input type="text" id="email" name="email"
                                        placeholder="Masukkan email anda" required
                                        class="flex-1 p-0 border-none bg-[#E9BF80] placeholder-[#6B592E] font-Poppins text-sm focus:outline-none focus:ring-0" /> --}}
                            </label>
                        </div>

                        {{-- INPUT PASSWORD --}}
                        <div
                            class="mb-4 text-[#6B592E] flex justify-between flex-wrap py-4 border-none bg-[#E9BF80] rounded-md items-center cursor-text">
                            <label for="password"
                                class=" flex flex-1 flex-wrap border-none bg-[#E9BF80] rounded-md items-center cursor-text">
                                <div class="w-4 h-4 mx-4 flex items-center justify-center overflow-hidden">
                                    <!-- SVG icon -->
                                    <svg version="1.0" xmlns="http://www.w3.org/2000/svg" class="w-full h-full"
                                        viewBox="0 0 710.000000 710.000000" preserveAspectRatio="xMidYMid meet">

                                        <g transform="translate(0.000000,710.000000) scale(0.100000,-0.100000)"
                                            fill="#6B592E" stroke="none">
                                            <path d="M3435 7083 c-408 -23 -783 -161 -1115 -407 -392 -292 -675 -740 -765
-1210 -37 -198 -45 -294 -45 -608 l0 -287 -57 -6 c-96 -12 -242 -63 -329 -117
-206 -125 -339 -337 -365 -578 -12 -117 -12 -3052 1 -3160 21 -182 102 -352
226 -475 83 -82 151 -125 277 -174 l92 -36 2140 -3 c1531 -2 2158 0 2205 8
141 24 276 97 390 212 85 86 142 175 181 288 l34 95 3 1633 c3 1782 6 1677
-54 1834 -93 245 -334 429 -617 469 l-85 13 -5 375 c-4 374 -4 377 -35 521
-146 690 -577 1204 -1234 1474 -240 99 -580 155 -843 139z m346 -528 c305 -54
566 -188 798 -410 245 -233 392 -515 440 -842 18 -118 21 -189 21 -437 l0
-296 -1511 0 -1512 0 6 303 c6 359 21 478 79 652 122 361 341 639 653 827 148
90 367 172 538 203 102 19 384 19 488 0z m-35 -3560 c105 -53 193 -142 243
-245 32 -68 36 -85 39 -176 7 -188 -61 -331 -209 -440 l-39 -29 0 -185 c0
-173 -2 -188 -24 -235 -30 -66 -75 -109 -133 -129 -128 -44 -258 12 -314 136
-22 49 -24 69 -27 240 l-4 186 -39 27 c-93 65 -179 208 -201 334 -16 91 -1
168 51 278 49 101 104 163 190 211 113 63 152 73 277 70 107 -3 114 -4 190
-43z" />
                                        </g>
                                    </svg>
                                </div>

                                <input wire:model="password" id="password"
                                    class="flex-1 p-0 border-none bg-[#E9BF80] placeholder-[#6B592E] font-Poppins text-sm focus:outline-none focus:ring-0"
                                    type="password" name="password" required autocomplete="new-password"
                                    placeholder="Masukkan pasword anda" />

                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                {{-- <input type="password" id="password" name="password"
                                        placeholder="Masukkan password anda" required
                                        class="flex-1 p-0 border-none bg-[#E9BF80] placeholder-[#6B592E] font-Poppins text-sm focus:outline-none focus:ring-0" /> --}}
                            </label>
                            <div class="w-4 h-4 mx-4 cursor-pointer"
                                onclick="togglePassword('password', 'openIcon2', 'closedIcon2')">
                                <!-- SVG icon MATA -->
                                <span id="openIcon2" class="toggle-icon">
                                    <svg id="eye-konfirmasi-closed" version="1.0" xmlns="http://www.w3.org/2000/svg"
                                        class="w-full h-full pointer-events-none"
                                        viewBox="0 0 1181.000000 1181.000000" preserveAspectRatio="xMidYMid meet">

                                        <g transform="translate(0.000000,1181.000000) scale(0.100000,-0.100000)"
                                            fill="#6B592E" stroke="none">
                                            <path d="M625 10581 c-42 -11 -84 -35 -122 -68 -38 -34 -384 -479 -420 -541
-55 -94 -39 -240 35 -321 38 -41 10761 -8322 10842 -8373 91 -57 218 -54 308
6 33 22 104 104 239 276 241 307 248 320 247 425 0 94 -28 159 -91 216 -21 19
-487 380 -1036 803 -548 424 -997 773 -997 776 0 3 66 64 146 135 452 400 899
954 1207 1497 165 291 192 368 184 533 -5 123 -24 175 -138 387 -463 862
-1107 1566 -1924 2100 -471 308 -898 514 -1426 689 -1172 387 -2395 397 -3517
30 -291 -96 -625 -238 -856 -366 l-100 -55 -35 28 c-326 258 -2318 1785 -2349
1801 -47 24 -148 35 -197 22z m5590 -2056 c250 -36 425 -81 649 -169 453 -177
870 -491 1157 -871 436 -576 612 -1334 474 -2042 -37 -193 -131 -482 -197
-607 l-13 -25 -349 269 c-192 148 -354 274 -358 278 -6 6 5 69 26 153 41 166
56 275 56 407 0 350 -100 677 -298 973 -348 520 -946 817 -1551 769 -114 -9
-344 -50 -357 -63 -2 -2 16 -39 41 -82 75 -132 115 -280 115 -426 0 -66 -15
-176 -26 -187 -1 -2 -209 155 -461 350 -252 194 -554 427 -670 517 -117 91
-213 167 -213 171 0 12 99 88 231 176 364 243 763 384 1199 423 134 12 416 5
545 -14z" />
                                            <path d="M1320 7132 c-333 -431 -619 -891 -667 -1075 -21 -80 -20 -215 1 -297
44 -168 366 -708 615 -1035 318 -415 723 -815 1146 -1132 1030 -771 2256
-1190 3495 -1193 251 0 607 29 853 70 145 25 421 84 501 108 l59 17 -464 360
c-531 412 -450 371 -684 341 -112 -15 -182 -17 -350 -13 -230 6 -367 24 -573
76 -842 214 -1539 854 -1826 1678 -65 189 -136 519 -136 636 0 34 -7 41 -217
203 -120 92 -552 426 -960 741 -408 315 -744 573 -745 573 -2 0 -23 -26 -48
-58z" />
                                        </g>
                                    </svg>
                                </span>
                                <span id="closedIcon2" class="toggle-icon hidden">
                                    <svg id="eye-konfirmasi-open" version="1.0" xmlns="http://www.w3.org/2000/svg"
                                        class="w-full h-full pointer-events-none"
                                        viewBox="0 0 1350.000000 1350.000000" preserveAspectRatio="xMidYMid meet">

                                        <g transform="translate(0.000000,1350.000000) scale(0.100000,-0.100000)"
                                            fill="#6B592E" stroke="none">
                                            <path d="M6705 10950 c-4 -6 -78 -10 -190 -10 -112 0 -186 -4 -190 -10 -3 -6
-50 -10 -105 -10 -55 0 -102 -4 -105 -10 -3 -5 -37 -10 -75 -10 -38 0 -72 -4
-75 -10 -3 -5 -37 -10 -75 -10 -38 0 -72 -4 -75 -10 -3 -5 -35 -10 -70 -10
-35 0 -66 -4 -69 -8 -3 -5 -52 -12 -110 -15 -57 -4 -130 -14 -162 -23 -54 -15
-98 -24 -192 -41 -18 -3 -35 -9 -38 -14 -3 -5 -20 -9 -39 -9 -19 0 -37 -4 -40
-10 -3 -5 -21 -10 -40 -10 -19 0 -37 -4 -40 -10 -3 -5 -21 -10 -40 -10 -19 0
-37 -4 -40 -10 -3 -5 -24 -10 -45 -10 -21 0 -42 -4 -45 -10 -3 -5 -17 -10 -30
-10 -13 0 -27 -4 -30 -10 -3 -5 -18 -10 -33 -10 -25 0 -226 -61 -264 -81 -10
-5 -31 -9 -48 -9 -16 0 -30 -4 -30 -10 0 -5 -11 -10 -24 -10 -14 0 -28 -4 -31
-10 -3 -5 -15 -10 -25 -10 -11 0 -35 -9 -55 -20 -20 -11 -44 -20 -53 -20 -10
0 -22 -4 -28 -9 -5 -4 -47 -21 -94 -36 -47 -15 -121 -45 -165 -66 -44 -22 -85
-39 -92 -39 -6 0 -36 -13 -66 -30 -30 -16 -60 -30 -66 -30 -16 0 -285 -132
-289 -142 -2 -4 -14 -8 -27 -8 -12 0 -28 -6 -34 -14 -7 -8 -40 -29 -74 -45
-34 -17 -75 -40 -92 -50 -16 -11 -38 -20 -48 -20 -10 -1 -52 -24 -94 -52 -41
-28 -103 -64 -138 -80 -34 -16 -72 -41 -85 -54 -13 -14 -29 -25 -37 -25 -7 0
-13 -4 -13 -8 0 -5 -21 -20 -47 -33 -27 -13 -50 -26 -53 -29 -6 -7 -115 -81
-141 -96 -10 -6 -27 -18 -37 -27 -10 -10 -23 -17 -29 -17 -5 0 -18 -9 -28 -20
-10 -11 -23 -20 -30 -20 -6 0 -26 -16 -45 -35 -19 -19 -39 -35 -45 -35 -7 0
-20 -9 -30 -20 -10 -11 -22 -20 -27 -20 -4 0 -22 -13 -40 -30 -17 -16 -35 -30
-39 -30 -5 0 -26 -16 -46 -35 -20 -19 -41 -35 -45 -35 -5 0 -22 -13 -40 -30
-17 -16 -35 -30 -40 -30 -5 0 -28 -19 -52 -42 -24 -24 -81 -74 -126 -113 -46
-38 -147 -132 -225 -209 -79 -76 -154 -143 -166 -150 -13 -6 -29 -22 -35 -35
-7 -12 -74 -87 -150 -166 -77 -78 -170 -179 -209 -225 -38 -45 -85 -97 -103
-116 -17 -18 -32 -38 -32 -43 0 -5 -18 -27 -40 -50 -22 -22 -40 -44 -40 -49 0
-4 -11 -19 -25 -34 -14 -15 -25 -31 -25 -36 0 -5 -18 -28 -40 -51 -22 -22 -40
-45 -40 -49 0 -5 -9 -17 -20 -27 -11 -10 -20 -22 -20 -28 0 -5 -12 -25 -27
-43 -16 -19 -40 -49 -55 -68 -16 -18 -28 -39 -28 -45 0 -6 -4 -11 -10 -11 -5
0 -10 -9 -10 -20 0 -11 -3 -20 -7 -20 -5 0 -26 -28 -48 -63 -21 -34 -49 -75
-62 -90 -12 -15 -30 -43 -39 -62 -9 -19 -20 -35 -25 -35 -5 0 -9 -6 -9 -14 0
-7 -7 -19 -15 -26 -8 -7 -27 -37 -42 -69 -15 -31 -37 -69 -48 -86 -12 -16 -29
-47 -39 -67 -9 -20 -22 -43 -29 -50 -21 -21 -89 -168 -100 -212 -12 -52 -12
-90 0 -142 10 -44 63 -157 75 -162 4 -2 8 -9 8 -16 0 -7 8 -21 17 -32 19 -20
45 -65 90 -154 15 -30 36 -64 45 -74 10 -11 18 -26 18 -33 0 -7 4 -13 8 -13 5
0 15 -12 22 -27 8 -16 33 -56 57 -91 24 -35 43 -67 43 -71 0 -4 9 -16 20 -26
11 -10 20 -24 20 -30 0 -7 7 -18 15 -25 9 -7 24 -32 35 -54 10 -23 28 -50 40
-61 21 -19 80 -101 80 -111 0 -2 14 -18 30 -36 17 -17 30 -35 30 -41 0 -5 8
-17 18 -26 9 -9 33 -38 52 -65 36 -50 106 -132 210 -247 33 -37 60 -71 60 -76
0 -5 13 -22 30 -38 16 -16 30 -35 30 -42 0 -7 6 -13 13 -13 15 0 77 -61 77
-76 0 -12 482 -494 494 -494 5 0 46 -35 91 -77 86 -82 176 -158 246 -208 23
-16 56 -45 75 -63 18 -17 38 -32 42 -32 5 0 22 -12 38 -27 16 -16 42 -34 57
-42 15 -8 27 -18 27 -22 0 -5 15 -16 32 -25 18 -9 40 -25 49 -35 9 -11 21 -19
26 -19 6 0 18 -9 28 -20 10 -11 23 -20 30 -20 7 0 20 -9 30 -20 10 -11 24 -20
30 -20 7 0 18 -7 25 -15 13 -16 126 -95 136 -95 6 0 95 -60 104 -69 9 -10 63
-41 117 -67 28 -13 57 -31 63 -39 7 -8 18 -15 25 -15 7 0 18 -6 24 -14 7 -8
67 -42 134 -76 67 -34 124 -64 127 -68 7 -11 353 -182 366 -182 6 0 46 -18 89
-40 43 -22 83 -40 90 -40 7 0 33 -11 56 -25 24 -14 76 -34 114 -46 39 -12 74
-25 80 -30 5 -5 19 -9 32 -9 13 0 23 -4 23 -10 0 -5 9 -10 20 -10 11 0 20 -4
20 -10 0 -5 9 -10 20 -10 11 0 35 -9 55 -20 20 -11 44 -20 55 -20 10 0 22 -5
25 -10 3 -5 21 -10 40 -10 19 0 37 -4 40 -10 3 -5 16 -10 29 -10 12 0 26 -4
31 -8 6 -5 53 -21 105 -37 115 -34 150 -48 150 -57 0 -5 20 -8 44 -8 25 0 48
-5 51 -10 3 -6 21 -10 40 -10 19 0 37 -4 40 -10 3 -5 21 -10 40 -10 19 0 37
-4 40 -10 3 -5 16 -10 27 -10 22 0 38 -4 153 -40 38 -12 95 -25 127 -28 32 -2
61 -9 64 -13 3 -5 32 -9 64 -9 32 0 62 -4 65 -10 3 -5 35 -10 70 -10 35 0 67
-4 70 -10 3 -5 24 -10 45 -10 21 0 42 -4 45 -10 3 -5 35 -10 70 -10 35 0 67
-5 70 -10 3 -6 32 -10 64 -10 31 0 61 -4 66 -9 6 -5 46 -12 90 -15 44 -3 130
-11 190 -17 144 -14 926 -14 1070 0 61 6 146 14 190 17 44 3 84 10 90 15 5 5
30 9 56 9 26 0 51 4 54 10 3 5 35 10 70 10 35 0 67 5 70 10 3 6 28 10 55 10
27 0 52 5 55 10 3 6 30 10 60 10 30 0 57 4 60 10 3 5 33 10 65 10 32 0 61 4
64 9 3 4 34 11 68 14 35 4 77 11 93 16 17 5 49 15 73 20 87 22 127 35 137 43
5 4 24 8 41 8 18 0 36 5 39 10 3 6 26 10 50 10 24 0 47 5 50 10 3 6 22 10 41
10 19 0 34 5 34 10 0 6 9 10 20 10 11 0 28 4 38 9 9 5 60 21 112 37 52 15 99
31 105 36 5 4 19 8 31 8 13 0 26 5 29 10 3 6 19 10 35 10 16 0 45 9 65 20 20
11 42 20 49 20 8 0 31 9 53 19 56 28 103 47 148 60 55 17 123 45 240 102 55
27 105 49 111 49 12 0 427 209 519 261 33 19 74 41 90 49 17 8 38 21 47 28 18
15 63 41 158 89 30 15 68 40 84 56 16 15 33 27 38 27 5 0 52 29 104 65 52 36
98 65 103 65 4 0 16 9 26 20 10 11 23 20 30 20 7 0 20 9 30 20 10 11 22 20 27
20 4 0 22 14 40 30 17 17 36 30 43 30 6 0 22 11 35 25 13 14 29 25 37 25 7 0
13 4 13 8 0 5 12 15 28 23 15 8 43 30 62 49 19 19 57 51 83 70 60 43 165 133
261 223 40 37 77 67 82 67 5 0 45 36 89 81 44 44 90 85 103 90 12 5 25 17 29
26 8 25 84 103 99 103 7 0 23 14 36 31 13 18 78 89 146 158 67 70 122 131 122
136 0 4 26 36 58 70 31 34 77 87 102 119 25 32 61 78 80 102 19 24 53 66 75
94 22 29 46 58 53 65 6 7 12 18 12 23 0 5 18 28 40 51 22 22 40 43 40 46 0 8
60 92 75 105 8 7 15 18 15 25 0 6 9 20 20 30 11 10 20 23 20 28 0 6 7 19 17
29 9 10 21 27 27 37 6 11 37 58 69 105 31 48 57 90 57 94 0 5 8 17 18 28 9 10
24 33 32 49 8 17 28 50 45 75 17 25 42 68 55 95 14 28 28 52 33 53 4 2 7 12 7
22 0 10 4 20 8 22 17 7 50 66 71 124 32 91 29 167 -11 251 -18 37 -38 74 -44
80 -7 7 -25 39 -40 70 -16 32 -43 80 -61 107 -18 26 -33 54 -33 61 0 6 -9 20
-20 30 -11 10 -20 24 -20 30 0 7 -7 18 -15 25 -8 7 -27 37 -42 69 -15 31 -34
63 -43 71 -19 18 -90 127 -90 137 0 5 -14 22 -30 40 -17 18 -30 34 -30 37 0 9
-100 153 -115 166 -8 7 -15 18 -15 25 0 6 -15 26 -34 43 -19 17 -43 48 -52 68
-9 20 -41 61 -71 91 -29 30 -53 59 -53 64 0 6 -20 29 -45 53 -25 25 -45 48
-45 53 0 4 -17 26 -38 48 -21 22 -45 51 -54 64 -9 13 -53 60 -97 106 -45 45
-81 85 -81 89 0 11 -313 326 -323 326 -5 0 -47 36 -92 81 -46 44 -93 88 -106
97 -13 9 -47 38 -76 65 -28 27 -62 56 -75 65 -13 9 -40 33 -60 54 -20 21 -40
38 -45 38 -4 0 -24 14 -43 30 -19 16 -38 30 -42 30 -4 0 -28 20 -52 45 -25 25
-49 45 -54 45 -5 0 -17 9 -27 20 -10 11 -22 20 -28 20 -5 0 -25 12 -43 28 -70
56 -100 78 -129 92 -16 8 -39 23 -49 33 -11 9 -24 17 -28 17 -5 0 -19 9 -31
21 -23 22 -103 74 -149 98 -16 8 -28 18 -28 23 0 4 -6 8 -13 8 -7 0 -23 9 -35
20 -12 11 -25 20 -30 20 -5 0 -15 7 -22 15 -7 9 -38 27 -68 41 -30 14 -69 36
-87 49 -17 14 -35 25 -39 25 -4 0 -26 13 -49 28 -23 16 -76 45 -117 66 -41 20
-111 55 -155 78 -44 22 -99 50 -122 61 -24 11 -43 24 -43 29 0 4 -9 8 -20 8
-21 0 -49 13 -89 43 -13 9 -30 17 -38 17 -17 0 -55 16 -168 71 -44 22 -85 39
-92 39 -6 0 -28 8 -50 19 -21 10 -76 31 -123 47 -47 15 -100 36 -118 46 -18
10 -41 18 -52 18 -10 0 -22 5 -25 10 -3 6 -15 10 -26 10 -10 0 -28 5 -39 10
-11 6 -29 15 -40 20 -11 6 -31 10 -45 10 -14 0 -33 4 -43 9 -9 5 -71 26 -137
46 -66 21 -128 42 -137 46 -10 5 -27 9 -37 9 -11 0 -23 5 -26 10 -3 6 -26 10
-51 10 -24 0 -44 5 -44 10 0 6 -20 10 -44 10 -25 0 -48 5 -51 10 -3 6 -21 10
-40 10 -19 0 -37 5 -40 10 -3 6 -21 10 -40 10 -19 0 -36 4 -39 9 -3 5 -20 11
-38 14 -18 3 -53 11 -78 17 -135 34 -236 50 -312 50 -37 0 -70 5 -73 10 -3 6
-35 10 -71 10 -36 0 -64 4 -64 10 0 6 -28 10 -64 10 -36 0 -68 5 -71 10 -3 6
-42 10 -85 10 -43 0 -82 5 -85 10 -3 6 -50 10 -105 10 -55 0 -102 4 -105 10
-4 6 -78 10 -190 10 -112 0 -186 4 -190 10 -3 6 -33 10 -65 10 -32 0 -62 -4
-65 -10z m260 -2540 c3 -5 30 -10 60 -10 30 0 57 -4 60 -10 3 -5 26 -10 50
-10 24 0 47 -4 50 -10 3 -5 17 -10 31 -10 13 0 32 -4 42 -9 9 -5 37 -15 62
-22 25 -7 83 -32 128 -56 46 -24 92 -43 101 -43 10 0 26 -8 37 -18 10 -10 36
-26 56 -35 20 -10 40 -22 43 -27 7 -11 93 -70 102 -70 4 0 39 -31 79 -70 39
-38 77 -70 83 -70 6 0 11 -6 11 -13 0 -7 29 -42 65 -77 36 -35 65 -69 65 -76
0 -6 9 -19 20 -29 11 -10 20 -22 20 -27 0 -5 13 -23 30 -41 16 -18 30 -38 30
-44 0 -7 4 -13 8 -13 5 0 21 -28 36 -62 15 -35 50 -108 76 -163 51 -107 86
-230 102 -360 11 -90 13 -448 3 -540 -7 -73 -53 -266 -66 -279 -5 -6 -9 -20
-9 -32 0 -12 -3 -24 -7 -26 -11 -4 -73 -128 -73 -145 0 -16 -13 -39 -57 -105
-18 -26 -33 -52 -33 -56 0 -5 -9 -17 -20 -27 -11 -10 -20 -23 -20 -30 0 -6
-13 -24 -30 -40 -16 -16 -30 -34 -30 -40 0 -23 -313 -315 -338 -315 -5 0 -17
-9 -27 -20 -10 -11 -24 -20 -30 -20 -7 0 -18 -6 -24 -14 -19 -23 -297 -156
-325 -156 -14 0 -28 -4 -31 -10 -3 -5 -21 -10 -40 -10 -19 0 -37 -4 -40 -10
-3 -5 -17 -10 -30 -10 -13 0 -27 -4 -30 -10 -3 -5 -19 -10 -35 -10 -16 0 -32
-4 -35 -10 -3 -5 -30 -10 -60 -10 -30 0 -57 -4 -60 -10 -8 -13 -382 -13 -390
0 -3 6 -26 10 -50 10 -24 0 -47 5 -50 10 -3 6 -24 10 -45 10 -21 0 -42 5 -45
10 -3 6 -17 10 -30 10 -13 0 -27 5 -30 10 -3 6 -21 10 -40 10 -19 0 -37 5 -40
10 -3 6 -15 10 -26 10 -10 0 -27 4 -37 9 -9 5 -48 23 -87 40 -38 16 -76 36
-85 43 -8 7 -49 30 -91 51 -41 20 -86 48 -99 62 -13 14 -28 25 -32 25 -24 0
-298 253 -298 275 0 6 -13 24 -30 40 -16 16 -30 34 -30 40 0 6 -11 22 -26 35
-14 14 -34 43 -44 65 -11 22 -24 47 -29 55 -5 8 -14 26 -20 40 -7 14 -30 58
-51 99 -22 41 -40 82 -40 93 0 10 -4 18 -10 18 -5 0 -10 11 -10 24 0 14 -4 27
-9 30 -4 3 -11 25 -14 48 -4 24 -14 68 -23 98 -29 98 -37 171 -37 375 0 190 7
263 33 365 6 25 17 73 23 107 7 34 15 65 20 69 4 4 7 15 7 24 0 16 58 139 70
150 3 3 23 42 45 88 21 45 42 82 47 82 4 0 8 6 8 13 0 7 14 26 30 42 17 16 30
34 30 40 0 7 9 20 20 30 11 10 20 23 20 29 0 14 252 266 266 266 6 0 19 9 29
20 10 11 23 20 30 20 6 0 22 11 35 25 13 14 29 25 36 25 6 0 17 6 23 14 7 8
67 41 134 74 173 84 215 102 237 102 10 0 22 5 25 10 3 6 19 10 35 10 16 0 32
5 35 10 3 6 26 10 50 10 24 0 47 5 50 10 3 6 30 10 60 10 30 0 57 5 60 10 4 6
80 10 195 10 115 0 191 -4 195 -10z" />
                                        </g>
                                    </svg>
                                </span>
                            </div>
                        </div>

                        {{-- CONFIRM PASSWORD --}}
                        <div
                            class="mb-4 text-[#6B592E] flex justify-between flex-wrap py-4 border-none bg-[#E9BF80] rounded-md items-center cursor-text">
                            <label for="password_confirmation"
                                class=" flex flex-1 flex-wrap border-none bg-[#E9BF80] rounded-md items-center cursor-text">
                                <div class="w-4 h-4 mx-4 flex items-center justify-center overflow-hidden">
                                    <!-- SVG icon KUNCI -->
                                    <svg version="1.0" xmlns="http://www.w3.org/2000/svg" class="w-full h-full"
                                        viewBox="0 0 710.000000 710.000000" preserveAspectRatio="xMidYMid meet">

                                        <g transform="translate(0.000000,710.000000) scale(0.100000,-0.100000)"
                                            fill="#6B592E" stroke="none">
                                            <path d="M3435 7083 c-408 -23 -783 -161 -1115 -407 -392 -292 -675 -740 -765
-1210 -37 -198 -45 -294 -45 -608 l0 -287 -57 -6 c-96 -12 -242 -63 -329 -117
-206 -125 -339 -337 -365 -578 -12 -117 -12 -3052 1 -3160 21 -182 102 -352
226 -475 83 -82 151 -125 277 -174 l92 -36 2140 -3 c1531 -2 2158 0 2205 8
141 24 276 97 390 212 85 86 142 175 181 288 l34 95 3 1633 c3 1782 6 1677
-54 1834 -93 245 -334 429 -617 469 l-85 13 -5 375 c-4 374 -4 377 -35 521
-146 690 -577 1204 -1234 1474 -240 99 -580 155 -843 139z m346 -528 c305 -54
566 -188 798 -410 245 -233 392 -515 440 -842 18 -118 21 -189 21 -437 l0
-296 -1511 0 -1512 0 6 303 c6 359 21 478 79 652 122 361 341 639 653 827 148
90 367 172 538 203 102 19 384 19 488 0z m-35 -3560 c105 -53 193 -142 243
-245 32 -68 36 -85 39 -176 7 -188 -61 -331 -209 -440 l-39 -29 0 -185 c0
-173 -2 -188 -24 -235 -30 -66 -75 -109 -133 -129 -128 -44 -258 12 -314 136
-22 49 -24 69 -27 240 l-4 186 -39 27 c-93 65 -179 208 -201 334 -16 91 -1
168 51 278 49 101 104 163 190 211 113 63 152 73 277 70 107 -3 114 -4 190
-43z" />
                                        </g>
                                    </svg>
                                </div>

                                <input wire:model="password_confirmation" id="password_confirmation"
                                    class="flex-1 p-0 border-none bg-[#E9BF80] placeholder-[#6B592E] font-Poppins text-sm focus:outline-none focus:ring-0"
                                    type="password" name="password_confirmation" required autocomplete="new-password"
                                    placeholder="Konfirmasi password anda" />

                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                {{-- <input type="password" id="password_confirmation"
                                        placeholder="Konfirmasi password anda"
                                        class="flex-1 p-0 border-none bg-[#E9BF80] placeholder-[#6B592E] font-Poppins text-sm focus:outline-none focus:ring-0"> --}}
                            </label>
                            <div class="w-4 h-4 mx-4 cursor-pointer"
                                onclick="togglePassword('password_confirmation', 'openIcon1', 'closedIcon1')">
                                <!-- SVG icon MATA -->
                                <span id="openIcon1" class="toggle-icon">
                                    <svg id="eye-konfirmasi-closed" version="1.0" xmlns="http://www.w3.org/2000/svg"
                                        class="w-full h-full pointer-events-none"
                                        viewBox="0 0 1181.000000 1181.000000" preserveAspectRatio="xMidYMid meet">

                                        <g transform="translate(0.000000,1181.000000) scale(0.100000,-0.100000)"
                                            fill="#6B592E" stroke="none">
                                            <path d="M625 10581 c-42 -11 -84 -35 -122 -68 -38 -34 -384 -479 -420 -541
-55 -94 -39 -240 35 -321 38 -41 10761 -8322 10842 -8373 91 -57 218 -54 308
6 33 22 104 104 239 276 241 307 248 320 247 425 0 94 -28 159 -91 216 -21 19
-487 380 -1036 803 -548 424 -997 773 -997 776 0 3 66 64 146 135 452 400 899
954 1207 1497 165 291 192 368 184 533 -5 123 -24 175 -138 387 -463 862
-1107 1566 -1924 2100 -471 308 -898 514 -1426 689 -1172 387 -2395 397 -3517
30 -291 -96 -625 -238 -856 -366 l-100 -55 -35 28 c-326 258 -2318 1785 -2349
1801 -47 24 -148 35 -197 22z m5590 -2056 c250 -36 425 -81 649 -169 453 -177
870 -491 1157 -871 436 -576 612 -1334 474 -2042 -37 -193 -131 -482 -197
-607 l-13 -25 -349 269 c-192 148 -354 274 -358 278 -6 6 5 69 26 153 41 166
56 275 56 407 0 350 -100 677 -298 973 -348 520 -946 817 -1551 769 -114 -9
-344 -50 -357 -63 -2 -2 16 -39 41 -82 75 -132 115 -280 115 -426 0 -66 -15
-176 -26 -187 -1 -2 -209 155 -461 350 -252 194 -554 427 -670 517 -117 91
-213 167 -213 171 0 12 99 88 231 176 364 243 763 384 1199 423 134 12 416 5
545 -14z" />
                                            <path d="M1320 7132 c-333 -431 -619 -891 -667 -1075 -21 -80 -20 -215 1 -297
44 -168 366 -708 615 -1035 318 -415 723 -815 1146 -1132 1030 -771 2256
-1190 3495 -1193 251 0 607 29 853 70 145 25 421 84 501 108 l59 17 -464 360
c-531 412 -450 371 -684 341 -112 -15 -182 -17 -350 -13 -230 6 -367 24 -573
76 -842 214 -1539 854 -1826 1678 -65 189 -136 519 -136 636 0 34 -7 41 -217
203 -120 92 -552 426 -960 741 -408 315 -744 573 -745 573 -2 0 -23 -26 -48
-58z" />
                                        </g>
                                    </svg>
                                </span>
                                <span id="closedIcon1" class="toggle-icon hidden">
                                    <svg id="eye-konfirmasi-open" version="1.0" xmlns="http://www.w3.org/2000/svg"
                                        class="w-full h-full pointer-events-none"
                                        viewBox="0 0 1350.000000 1350.000000" preserveAspectRatio="xMidYMid meet">

                                        <g transform="translate(0.000000,1350.000000) scale(0.100000,-0.100000)"
                                            fill="#6B592E" stroke="none">
                                            <path d="M6705 10950 c-4 -6 -78 -10 -190 -10 -112 0 -186 -4 -190 -10 -3 -6
-50 -10 -105 -10 -55 0 -102 -4 -105 -10 -3 -5 -37 -10 -75 -10 -38 0 -72 -4
-75 -10 -3 -5 -37 -10 -75 -10 -38 0 -72 -4 -75 -10 -3 -5 -35 -10 -70 -10
-35 0 -66 -4 -69 -8 -3 -5 -52 -12 -110 -15 -57 -4 -130 -14 -162 -23 -54 -15
-98 -24 -192 -41 -18 -3 -35 -9 -38 -14 -3 -5 -20 -9 -39 -9 -19 0 -37 -4 -40
-10 -3 -5 -21 -10 -40 -10 -19 0 -37 -4 -40 -10 -3 -5 -21 -10 -40 -10 -19 0
-37 -4 -40 -10 -3 -5 -24 -10 -45 -10 -21 0 -42 -4 -45 -10 -3 -5 -17 -10 -30
-10 -13 0 -27 -4 -30 -10 -3 -5 -18 -10 -33 -10 -25 0 -226 -61 -264 -81 -10
-5 -31 -9 -48 -9 -16 0 -30 -4 -30 -10 0 -5 -11 -10 -24 -10 -14 0 -28 -4 -31
-10 -3 -5 -15 -10 -25 -10 -11 0 -35 -9 -55 -20 -20 -11 -44 -20 -53 -20 -10
0 -22 -4 -28 -9 -5 -4 -47 -21 -94 -36 -47 -15 -121 -45 -165 -66 -44 -22 -85
-39 -92 -39 -6 0 -36 -13 -66 -30 -30 -16 -60 -30 -66 -30 -16 0 -285 -132
-289 -142 -2 -4 -14 -8 -27 -8 -12 0 -28 -6 -34 -14 -7 -8 -40 -29 -74 -45
-34 -17 -75 -40 -92 -50 -16 -11 -38 -20 -48 -20 -10 -1 -52 -24 -94 -52 -41
-28 -103 -64 -138 -80 -34 -16 -72 -41 -85 -54 -13 -14 -29 -25 -37 -25 -7 0
-13 -4 -13 -8 0 -5 -21 -20 -47 -33 -27 -13 -50 -26 -53 -29 -6 -7 -115 -81
-141 -96 -10 -6 -27 -18 -37 -27 -10 -10 -23 -17 -29 -17 -5 0 -18 -9 -28 -20
-10 -11 -23 -20 -30 -20 -6 0 -26 -16 -45 -35 -19 -19 -39 -35 -45 -35 -7 0
-20 -9 -30 -20 -10 -11 -22 -20 -27 -20 -4 0 -22 -13 -40 -30 -17 -16 -35 -30
-39 -30 -5 0 -26 -16 -46 -35 -20 -19 -41 -35 -45 -35 -5 0 -22 -13 -40 -30
-17 -16 -35 -30 -40 -30 -5 0 -28 -19 -52 -42 -24 -24 -81 -74 -126 -113 -46
-38 -147 -132 -225 -209 -79 -76 -154 -143 -166 -150 -13 -6 -29 -22 -35 -35
-7 -12 -74 -87 -150 -166 -77 -78 -170 -179 -209 -225 -38 -45 -85 -97 -103
-116 -17 -18 -32 -38 -32 -43 0 -5 -18 -27 -40 -50 -22 -22 -40 -44 -40 -49 0
-4 -11 -19 -25 -34 -14 -15 -25 -31 -25 -36 0 -5 -18 -28 -40 -51 -22 -22 -40
-45 -40 -49 0 -5 -9 -17 -20 -27 -11 -10 -20 -22 -20 -28 0 -5 -12 -25 -27
-43 -16 -19 -40 -49 -55 -68 -16 -18 -28 -39 -28 -45 0 -6 -4 -11 -10 -11 -5
0 -10 -9 -10 -20 0 -11 -3 -20 -7 -20 -5 0 -26 -28 -48 -63 -21 -34 -49 -75
-62 -90 -12 -15 -30 -43 -39 -62 -9 -19 -20 -35 -25 -35 -5 0 -9 -6 -9 -14 0
-7 -7 -19 -15 -26 -8 -7 -27 -37 -42 -69 -15 -31 -37 -69 -48 -86 -12 -16 -29
-47 -39 -67 -9 -20 -22 -43 -29 -50 -21 -21 -89 -168 -100 -212 -12 -52 -12
-90 0 -142 10 -44 63 -157 75 -162 4 -2 8 -9 8 -16 0 -7 8 -21 17 -32 19 -20
45 -65 90 -154 15 -30 36 -64 45 -74 10 -11 18 -26 18 -33 0 -7 4 -13 8 -13 5
0 15 -12 22 -27 8 -16 33 -56 57 -91 24 -35 43 -67 43 -71 0 -4 9 -16 20 -26
11 -10 20 -24 20 -30 0 -7 7 -18 15 -25 9 -7 24 -32 35 -54 10 -23 28 -50 40
-61 21 -19 80 -101 80 -111 0 -2 14 -18 30 -36 17 -17 30 -35 30 -41 0 -5 8
-17 18 -26 9 -9 33 -38 52 -65 36 -50 106 -132 210 -247 33 -37 60 -71 60 -76
0 -5 13 -22 30 -38 16 -16 30 -35 30 -42 0 -7 6 -13 13 -13 15 0 77 -61 77
-76 0 -12 482 -494 494 -494 5 0 46 -35 91 -77 86 -82 176 -158 246 -208 23
-16 56 -45 75 -63 18 -17 38 -32 42 -32 5 0 22 -12 38 -27 16 -16 42 -34 57
-42 15 -8 27 -18 27 -22 0 -5 15 -16 32 -25 18 -9 40 -25 49 -35 9 -11 21 -19
26 -19 6 0 18 -9 28 -20 10 -11 23 -20 30 -20 7 0 20 -9 30 -20 10 -11 24 -20
30 -20 7 0 18 -7 25 -15 13 -16 126 -95 136 -95 6 0 95 -60 104 -69 9 -10 63
-41 117 -67 28 -13 57 -31 63 -39 7 -8 18 -15 25 -15 7 0 18 -6 24 -14 7 -8
67 -42 134 -76 67 -34 124 -64 127 -68 7 -11 353 -182 366 -182 6 0 46 -18 89
-40 43 -22 83 -40 90 -40 7 0 33 -11 56 -25 24 -14 76 -34 114 -46 39 -12 74
-25 80 -30 5 -5 19 -9 32 -9 13 0 23 -4 23 -10 0 -5 9 -10 20 -10 11 0 20 -4
20 -10 0 -5 9 -10 20 -10 11 0 35 -9 55 -20 20 -11 44 -20 55 -20 10 0 22 -5
25 -10 3 -5 21 -10 40 -10 19 0 37 -4 40 -10 3 -5 16 -10 29 -10 12 0 26 -4
31 -8 6 -5 53 -21 105 -37 115 -34 150 -48 150 -57 0 -5 20 -8 44 -8 25 0 48
-5 51 -10 3 -6 21 -10 40 -10 19 0 37 -4 40 -10 3 -5 21 -10 40 -10 19 0 37
-4 40 -10 3 -5 16 -10 27 -10 22 0 38 -4 153 -40 38 -12 95 -25 127 -28 32 -2
61 -9 64 -13 3 -5 32 -9 64 -9 32 0 62 -4 65 -10 3 -5 35 -10 70 -10 35 0 67
-4 70 -10 3 -5 24 -10 45 -10 21 0 42 -4 45 -10 3 -5 35 -10 70 -10 35 0 67
-5 70 -10 3 -6 32 -10 64 -10 31 0 61 -4 66 -9 6 -5 46 -12 90 -15 44 -3 130
-11 190 -17 144 -14 926 -14 1070 0 61 6 146 14 190 17 44 3 84 10 90 15 5 5
30 9 56 9 26 0 51 4 54 10 3 5 35 10 70 10 35 0 67 5 70 10 3 6 28 10 55 10
27 0 52 5 55 10 3 6 30 10 60 10 30 0 57 4 60 10 3 5 33 10 65 10 32 0 61 4
64 9 3 4 34 11 68 14 35 4 77 11 93 16 17 5 49 15 73 20 87 22 127 35 137 43
5 4 24 8 41 8 18 0 36 5 39 10 3 6 26 10 50 10 24 0 47 5 50 10 3 6 22 10 41
10 19 0 34 5 34 10 0 6 9 10 20 10 11 0 28 4 38 9 9 5 60 21 112 37 52 15 99
31 105 36 5 4 19 8 31 8 13 0 26 5 29 10 3 6 19 10 35 10 16 0 45 9 65 20 20
11 42 20 49 20 8 0 31 9 53 19 56 28 103 47 148 60 55 17 123 45 240 102 55
27 105 49 111 49 12 0 427 209 519 261 33 19 74 41 90 49 17 8 38 21 47 28 18
15 63 41 158 89 30 15 68 40 84 56 16 15 33 27 38 27 5 0 52 29 104 65 52 36
98 65 103 65 4 0 16 9 26 20 10 11 23 20 30 20 7 0 20 9 30 20 10 11 22 20 27
20 4 0 22 14 40 30 17 17 36 30 43 30 6 0 22 11 35 25 13 14 29 25 37 25 7 0
13 4 13 8 0 5 12 15 28 23 15 8 43 30 62 49 19 19 57 51 83 70 60 43 165 133
261 223 40 37 77 67 82 67 5 0 45 36 89 81 44 44 90 85 103 90 12 5 25 17 29
26 8 25 84 103 99 103 7 0 23 14 36 31 13 18 78 89 146 158 67 70 122 131 122
136 0 4 26 36 58 70 31 34 77 87 102 119 25 32 61 78 80 102 19 24 53 66 75
94 22 29 46 58 53 65 6 7 12 18 12 23 0 5 18 28 40 51 22 22 40 43 40 46 0 8
60 92 75 105 8 7 15 18 15 25 0 6 9 20 20 30 11 10 20 23 20 28 0 6 7 19 17
29 9 10 21 27 27 37 6 11 37 58 69 105 31 48 57 90 57 94 0 5 8 17 18 28 9 10
24 33 32 49 8 17 28 50 45 75 17 25 42 68 55 95 14 28 28 52 33 53 4 2 7 12 7
22 0 10 4 20 8 22 17 7 50 66 71 124 32 91 29 167 -11 251 -18 37 -38 74 -44
80 -7 7 -25 39 -40 70 -16 32 -43 80 -61 107 -18 26 -33 54 -33 61 0 6 -9 20
-20 30 -11 10 -20 24 -20 30 0 7 -7 18 -15 25 -8 7 -27 37 -42 69 -15 31 -34
63 -43 71 -19 18 -90 127 -90 137 0 5 -14 22 -30 40 -17 18 -30 34 -30 37 0 9
-100 153 -115 166 -8 7 -15 18 -15 25 0 6 -15 26 -34 43 -19 17 -43 48 -52 68
-9 20 -41 61 -71 91 -29 30 -53 59 -53 64 0 6 -20 29 -45 53 -25 25 -45 48
-45 53 0 4 -17 26 -38 48 -21 22 -45 51 -54 64 -9 13 -53 60 -97 106 -45 45
-81 85 -81 89 0 11 -313 326 -323 326 -5 0 -47 36 -92 81 -46 44 -93 88 -106
97 -13 9 -47 38 -76 65 -28 27 -62 56 -75 65 -13 9 -40 33 -60 54 -20 21 -40
38 -45 38 -4 0 -24 14 -43 30 -19 16 -38 30 -42 30 -4 0 -28 20 -52 45 -25 25
-49 45 -54 45 -5 0 -17 9 -27 20 -10 11 -22 20 -28 20 -5 0 -25 12 -43 28 -70
56 -100 78 -129 92 -16 8 -39 23 -49 33 -11 9 -24 17 -28 17 -5 0 -19 9 -31
21 -23 22 -103 74 -149 98 -16 8 -28 18 -28 23 0 4 -6 8 -13 8 -7 0 -23 9 -35
20 -12 11 -25 20 -30 20 -5 0 -15 7 -22 15 -7 9 -38 27 -68 41 -30 14 -69 36
-87 49 -17 14 -35 25 -39 25 -4 0 -26 13 -49 28 -23 16 -76 45 -117 66 -41 20
-111 55 -155 78 -44 22 -99 50 -122 61 -24 11 -43 24 -43 29 0 4 -9 8 -20 8
-21 0 -49 13 -89 43 -13 9 -30 17 -38 17 -17 0 -55 16 -168 71 -44 22 -85 39
-92 39 -6 0 -28 8 -50 19 -21 10 -76 31 -123 47 -47 15 -100 36 -118 46 -18
10 -41 18 -52 18 -10 0 -22 5 -25 10 -3 6 -15 10 -26 10 -10 0 -28 5 -39 10
-11 6 -29 15 -40 20 -11 6 -31 10 -45 10 -14 0 -33 4 -43 9 -9 5 -71 26 -137
46 -66 21 -128 42 -137 46 -10 5 -27 9 -37 9 -11 0 -23 5 -26 10 -3 6 -26 10
-51 10 -24 0 -44 5 -44 10 0 6 -20 10 -44 10 -25 0 -48 5 -51 10 -3 6 -21 10
-40 10 -19 0 -37 5 -40 10 -3 6 -21 10 -40 10 -19 0 -36 4 -39 9 -3 5 -20 11
-38 14 -18 3 -53 11 -78 17 -135 34 -236 50 -312 50 -37 0 -70 5 -73 10 -3 6
-35 10 -71 10 -36 0 -64 4 -64 10 0 6 -28 10 -64 10 -36 0 -68 5 -71 10 -3 6
-42 10 -85 10 -43 0 -82 5 -85 10 -3 6 -50 10 -105 10 -55 0 -102 4 -105 10
-4 6 -78 10 -190 10 -112 0 -186 4 -190 10 -3 6 -33 10 -65 10 -32 0 -62 -4
-65 -10z m260 -2540 c3 -5 30 -10 60 -10 30 0 57 -4 60 -10 3 -5 26 -10 50
-10 24 0 47 -4 50 -10 3 -5 17 -10 31 -10 13 0 32 -4 42 -9 9 -5 37 -15 62
-22 25 -7 83 -32 128 -56 46 -24 92 -43 101 -43 10 0 26 -8 37 -18 10 -10 36
-26 56 -35 20 -10 40 -22 43 -27 7 -11 93 -70 102 -70 4 0 39 -31 79 -70 39
-38 77 -70 83 -70 6 0 11 -6 11 -13 0 -7 29 -42 65 -77 36 -35 65 -69 65 -76
0 -6 9 -19 20 -29 11 -10 20 -22 20 -27 0 -5 13 -23 30 -41 16 -18 30 -38 30
-44 0 -7 4 -13 8 -13 5 0 21 -28 36 -62 15 -35 50 -108 76 -163 51 -107 86
-230 102 -360 11 -90 13 -448 3 -540 -7 -73 -53 -266 -66 -279 -5 -6 -9 -20
-9 -32 0 -12 -3 -24 -7 -26 -11 -4 -73 -128 -73 -145 0 -16 -13 -39 -57 -105
-18 -26 -33 -52 -33 -56 0 -5 -9 -17 -20 -27 -11 -10 -20 -23 -20 -30 0 -6
-13 -24 -30 -40 -16 -16 -30 -34 -30 -40 0 -23 -313 -315 -338 -315 -5 0 -17
-9 -27 -20 -10 -11 -24 -20 -30 -20 -7 0 -18 -6 -24 -14 -19 -23 -297 -156
-325 -156 -14 0 -28 -4 -31 -10 -3 -5 -21 -10 -40 -10 -19 0 -37 -4 -40 -10
-3 -5 -17 -10 -30 -10 -13 0 -27 -4 -30 -10 -3 -5 -19 -10 -35 -10 -16 0 -32
-4 -35 -10 -3 -5 -30 -10 -60 -10 -30 0 -57 -4 -60 -10 -8 -13 -382 -13 -390
0 -3 6 -26 10 -50 10 -24 0 -47 5 -50 10 -3 6 -24 10 -45 10 -21 0 -42 5 -45
10 -3 6 -17 10 -30 10 -13 0 -27 5 -30 10 -3 6 -21 10 -40 10 -19 0 -37 5 -40
10 -3 6 -15 10 -26 10 -10 0 -27 4 -37 9 -9 5 -48 23 -87 40 -38 16 -76 36
-85 43 -8 7 -49 30 -91 51 -41 20 -86 48 -99 62 -13 14 -28 25 -32 25 -24 0
-298 253 -298 275 0 6 -13 24 -30 40 -16 16 -30 34 -30 40 0 6 -11 22 -26 35
-14 14 -34 43 -44 65 -11 22 -24 47 -29 55 -5 8 -14 26 -20 40 -7 14 -30 58
-51 99 -22 41 -40 82 -40 93 0 10 -4 18 -10 18 -5 0 -10 11 -10 24 0 14 -4 27
-9 30 -4 3 -11 25 -14 48 -4 24 -14 68 -23 98 -29 98 -37 171 -37 375 0 190 7
263 33 365 6 25 17 73 23 107 7 34 15 65 20 69 4 4 7 15 7 24 0 16 58 139 70
150 3 3 23 42 45 88 21 45 42 82 47 82 4 0 8 6 8 13 0 7 14 26 30 42 17 16 30
34 30 40 0 7 9 20 20 30 11 10 20 23 20 29 0 14 252 266 266 266 6 0 19 9 29
20 10 11 23 20 30 20 6 0 22 11 35 25 13 14 29 25 36 25 6 0 17 6 23 14 7 8
67 41 134 74 173 84 215 102 237 102 10 0 22 5 25 10 3 6 19 10 35 10 16 0 32
5 35 10 3 6 26 10 50 10 24 0 47 5 50 10 3 6 30 10 60 10 30 0 57 5 60 10 4 6
80 10 195 10 115 0 191 -4 195 -10z" />
                                        </g>
                                    </svg>
                                </span>
                            </div>
                        </div>
                        <button
                            class="mt-3 bg-[#6B592E] w-full text-[#FFEDB7] hover:text-white text-sm font-bold py-4 px-10 rounded-md transition duration-300 ease-in-out hover:bg-[#B5964D] focus:outline-2">
                            DAFTAR SEKARANG!
                        </button>
                    </form>
                </div>
            </div>
            <div class="intros-container relative left-[50%] w-[50%] text-center">
                <div
                    class="intro-control signin-intro absolute w-[100%] flex justify-center flex-col h-[600px] transition duration-300 ease-in opacity-[1] z-20">
                    <div
                        class="absolute inset-1/2 -translate-x-1/2 -translate-y-1/2 w-[98%] h-[98%] bg-[#6B592E]/60 bg-no-repeat bg-center bg-contain z-0 rounded-xl shadow-xl">
                    </div>
                    <img src="{{ asset('assets/images/login/login.png') }}"
                        class="absolute inset-1/2 -translate-x-1/2 -translate-y-1/2 w-[98%] h-[98%] object-cover -z-10 rounded-xl shadow-xl"
                        alt="Background" />
                    <div class="intro-control__inner mx-[30px] z-30 relative">
                        <div class="flex flex-col items-center justify-center">
                            <div class="text-white text-5xl font-Kuunari font-bold text-center px-4">
                                <h1>BELUM PUNYA AKUN?</h1>
                            </div>
                            <div class="text-white text-sm font-Poppins text-center justify-center px-2">
                                <p class="my-[10px]">Gak usah ragu, daftar sekarang dan
                                    <br> temukan barber favoritmu!
                                </p>
                            </div>
                        </div>
                        <button id="signup-btn"
                            class="py-4 px-10 bg-Ecru text-Field-Drab hover:text-Ecru transition duration-200 hover:bg-Field-Drab font-Poppins font-semibold rounded-md">
                            DAFTAR SEKARANG
                        </button>
                    </div>
                </div>
                <div
                    class="intro-control signup-intro absolute w-[100%] flex justify-center flex-col h-[600px] transition duration-300 ease-in opacity-[0] z-10">
                    <div
                        class="absolute inset-1/2 -translate-x-1/2 -translate-y-1/2 w-[98%] h-[98%] bg-[#6B592E]/40 bg-no-repeat bg-center bg-contain z-0 rounded-xl shadow-xl">
                    </div>
                    <img src="{{ asset('assets/images/login/register.png') }}"
                        class="absolute inset-1/2 -translate-x-1/2 -translate-y-1/2 w-[98%] h-[98%] object-cover -z-10 rounded-xl shadow-xl"
                        alt="Background" />
                    <div class="intro-control__inner mx-[30px] z-30 relative">
                        <div class="flex flex-col items-center justify-center">
                            <div class="text-white text-4xl font-Kuunari font-bold text-center px-4">
                                <h1>SUDAH PUNYA AKUN?</h1>
                            </div>
                            <div class="text-white text-sm font-Poppins text-center justify-center px-2">
                                <p class="my-[10px]">Langsung masuk dan temukan <br> babershop favoritmu.</p>
                            </div>
                        </div>
                        <button id="signin-btn"
                            class="py-4 px-10 bg-Ecru text-Field-Drab hover:text-Ecru transition duration-200 hover:bg-Field-Drab font-Poppins font-semibold rounded-md">
                            Masuk Sekarang
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Initial state base z-index hierarchy:
           Forms: 1-2 (bottom layer)
           Intros: 10-20 (top layer) */

        .change .forms-container .form-control.signup-form {
            opacity: 1;
            z-index: 25;
            transform: translateX(0%);
            left: 100%;
        }

        .change .forms-container .form-control.signin-form {
            opacity: 0;
            z-index: 1;
            transform: translateX(-100%);
            left: -100%;
        }

        .change .intros-container .intro-control {
            transform: translateX(-100%);
        }

        .change .intros-container .intro-control.signin-intro {
            opacity: 0;
            z-index: 5;
        }

        .change .intros-container .intro-control.signup-intro {
            opacity: 1;
            z-index: 10;
        }
    </style>

    <script>
        // Password toggle functionality for registration form
        function togglePassword(inputId, openIconId, closedIconId) {
            const input = document.getElementById(inputId);
            const openIcon = document.getElementById(openIconId);
            const closedIcon = document.getElementById(closedIconId);

            if (input && openIcon && closedIcon) {
                if (input.type === 'password') {
                    input.type = 'text';
                    openIcon.classList.add('hidden');
                    closedIcon.classList.remove('hidden');
                } else {
                    input.type = 'password';
                    openIcon.classList.remove('hidden');
                    closedIcon.classList.add('hidden');
                }
            }
        }
    </script>
</div>

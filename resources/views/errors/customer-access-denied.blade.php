@extends('layouts.app')

@section('title', 'Access Denied')

@section('content')
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="max-w-md w-full text-center">
            <div class="mb-8">
                <div class="w-24 h-24 mx-auto mb-6 bg-red-100 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.232 14.5c-.77.833.192 2.5 1.732 2.5z">
                        </path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-4">Access Denied</h1>
                <p class="text-gray-600 mb-2">
                    The booking page is only accessible to regular customers.
                </p>
                <p class="text-sm text-gray-500">
                    Current role: <span class="font-semibold">{{ $userRole ?? 'Unknown' }}</span>
                </p>
            </div>

            <div class="space-y-4">
                @if ($previousUrl && $previousUrl !== url()->current())
                    <a href="{{ $previousUrl }}"
                        class="inline-block w-full bg-blue-600 text-white font-medium py-3 px-6 rounded-lg hover:bg-blue-700 transition-colors">
                        Go Back
                    </a>
                @endif

                <a href="{{ route('home') }}"
                    class="inline-block w-full bg-gray-600 text-white font-medium py-3 px-6 rounded-lg hover:bg-gray-700 transition-colors">
                    Go to Home
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full bg-red-600 text-white font-medium py-3 px-6 rounded-lg hover:bg-red-700 transition-colors">
                        Logout and Switch Account
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

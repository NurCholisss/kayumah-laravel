@extends('layouts.app')

@section('title', 'Masuk - KayUmah')
@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <!-- Header -->
        <div>
            <div class="flex justify-center">
                <div class="w-12 h-12 bg-amber-800 rounded-lg flex items-center justify-center">
                    <span class="text-white font-bold text-lg">K</span>
                </div>
            </div>
            <h2 class="mt-6 text-center text-3xl font-elegant font-bold text-gray-900">
                Masuk ke KayUmah
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Atau 
                <a href="{{ route('register') }}" class="font-medium text-amber-800 hover:text-amber-700 transition-colors">
                    buat akun baru
                </a>
            </p>
        </div>

        <!-- Login Form -->
        <form class="mt-8 space-y-6" action="{{ route('login.post') }}" method="POST">
            @csrf
            
            <!-- Flash Messages -->
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="rounded-md shadow-sm -space-y-px">
                <!-- Email -->
                <div>
                    <label for="email" class="sr-only">Alamat Email</label>
                    <input id="email" name="email" type="email" autocomplete="email" required
                           class="appearance-none rounded-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-amber-500 focus:border-amber-500 focus:z-10 sm:text-sm transition-colors"
                           placeholder="Alamat Email"
                           value="{{ old('email') }}">
                </div>
                
                <!-- Password -->
                <div>
                    <label for="password" class="sr-only">Password</label>
                    <input id="password" name="password" type="password" autocomplete="current-password" required
                           class="appearance-none rounded-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-amber-500 focus:border-amber-500 focus:z-10 sm:text-sm transition-colors"
                           placeholder="Password">
                </div>
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember" name="remember" type="checkbox"
                           class="h-4 w-4 text-amber-600 focus:ring-amber-500 border-gray-300 rounded">
                    <label for="remember" class="ml-2 block text-sm text-gray-900">
                        Ingat saya
                    </label>
                </div>

                @if (Route::has('password.request'))
                <div class="text-sm">
                    <a href="{{ route('password.request') }}" class="font-medium text-amber-800 hover:text-amber-700 transition-colors">
                        Lupa password?
                    </a>
                </div>
                @endif
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit"
                        class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-amber-800 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-colors">
                    Masuk
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
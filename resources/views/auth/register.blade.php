@extends('layouts.app')

@section('title', 'Daftar - KayUmah')
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
                Daftar Akun Baru
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Atau 
                <a href="{{ route('login') }}" class="font-medium text-amber-800 hover:text-amber-700 transition-colors">
                    masuk ke akun yang sudah ada
                </a>
            </p>
        </div>

        <!-- Register Form -->
        <form class="mt-8 space-y-6" action="{{ route('register.post') }}" method="POST">
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

            <div class="space-y-4">
                <!-- Name -->
                <div>
                    <label for="name" class="sr-only">Nama Lengkap</label>
                    <input id="name" name="name" type="text" autocomplete="name" required
                           class="appearance-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-amber-500 focus:border-amber-500 focus:z-10 sm:text-sm transition-colors"
                           placeholder="Nama Lengkap"
                           value="{{ old('name') }}">
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="sr-only">Alamat Email</label>
                    <input id="email" name="email" type="email" autocomplete="email" required
                           class="appearance-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-amber-500 focus:border-amber-500 focus:z-10 sm:text-sm transition-colors"
                           placeholder="Alamat Email"
                           value="{{ old('email') }}">
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="sr-only">Nomor Telepon</label>
                    <input id="phone" name="phone" type="tel" autocomplete="tel" required
                           class="appearance-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-amber-500 focus:border-amber-500 focus:z-10 sm:text-sm transition-colors"
                           placeholder="Nomor Telepon"
                           value="{{ old('phone') }}">
                </div>

                <!-- Address -->
                <div>
                    <label for="address" class="sr-only">Alamat Lengkap</label>
                    <textarea id="address" name="address" rows="3" required
                              class="appearance-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-amber-500 focus:border-amber-500 focus:z-10 sm:text-sm transition-colors"
                              placeholder="Alamat Lengkap">{{ old('address') }}</textarea>
                </div>
                
                <!-- Password -->
                <div>
                    <label for="password" class="sr-only">Password</label>
                    <input id="password" name="password" type="password" autocomplete="new-password" required
                           class="appearance-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-amber-500 focus:border-amber-500 focus:z-10 sm:text-sm transition-colors"
                           placeholder="Password">
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="sr-only">Konfirmasi Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required
                           class="appearance-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-amber-500 focus:border-amber-500 focus:z-10 sm:text-sm transition-colors"
                           placeholder="Konfirmasi Password">
                </div>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit"
                        class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-amber-800 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-colors">
                    Daftar
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
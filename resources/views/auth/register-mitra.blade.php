@extends('layouts.app')

@section('content')
<div class="min-h-[80vh] flex flex-col justify-center py-12 px-4 sm:px-6 lg:px-8 bg-white">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <h2 class="text-center text-3xl font-bold text-gray-900">
            Daftar Sebagai Mitra Catering
        </h2>
        <p class="mt-2 text-center text-sm text-gray-500">
            Kembangkan bisnis catering Anda bersama kami
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-6 shadow-sm rounded-xl border border-gray-100 sm:px-10">
            <form class="space-y-5" action="{{ route('register.mitra') }}" method="POST">
                @csrf

                @if ($errors->any())
                    <div class="rounded-lg bg-red-50 border border-red-100 p-4">
                        <h3 class="text-sm font-semibold text-red-800 mb-2">Terdapat kesalahan:</h3>
                        <ul class="list-disc pl-5 space-y-1 text-sm text-red-700">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-1">
                        Username
                    </label>
                    <input id="username" name="username" type="text" required
                           class="appearance-none block w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm placeholder-gray-400 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition"
                           value="{{ old('username') }}" placeholder="Masukkan username">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                        Email Address
                    </label>
                    <input id="email" name="email" type="email" autocomplete="email" required
                           class="appearance-none block w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm placeholder-gray-400 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition"
                           value="{{ old('email') }}" placeholder="nama@email.com">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                        Password
                    </label>
                    <input id="password" name="password" type="password" required
                           class="appearance-none block w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm placeholder-gray-400 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition"
                           placeholder="Minimal 8 karakter">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                        Konfirmasi Password
                    </label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required
                           class="appearance-none block w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm placeholder-gray-400 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition"
                           placeholder="Ulangi password">
                </div>

                <div class="pt-2">
                    <button type="submit"
                            class="btn-primary w-full flex justify-center py-3 px-4 rounded-lg text-sm font-semibold">
                        Daftar Menjadi Mitra
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center space-y-2">
                <p class="text-sm text-gray-600">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="font-semibold text-orange-500 hover:text-orange-600 transition">Masuk di sini</a>
                </p>
                <p class="text-sm text-gray-600">
                    Ingin mendaftar sebagai pembeli?
                    <a href="{{ route('register') }}" class="font-semibold text-orange-500 hover:text-orange-600 transition">Daftar disini</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

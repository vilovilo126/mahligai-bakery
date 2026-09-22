<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="theme-color" content="#0f2618">

        <title>Masuk · Mahligai Bakery</title>

        @fonts

        @vite(['resources/css/app.css', 'resources/css/custom.css'])
    </head>
    <body class="flex min-h-screen items-center justify-center bg-gradient-to-br from-brand-800 via-brand-950 to-brand-900 p-4 font-sans text-brand-950 antialiased">
        <div class="w-full max-w-sm">
            <a href="{{ route('home') }}" class="mx-auto flex w-fit items-center gap-2.5">
                <span class="grid h-11 w-11 place-items-center rounded-xl bg-white/10 text-white ring-1 ring-white/20">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6"><path d="M4 17.5C4 11.5 8 8 12 8c4 0 8 3.5 8 9.5 0 .8-1.3 1.5-4 1.5H8c-2.7 0-4-.7-4-1.5Z"/></svg>
                </span>
                <span class="font-display text-lg font-semibold text-white">Mahligai Bakery</span>
            </a>

            <div class="mt-6 rounded-3xl bg-white p-7 shadow-2xl">
                <h1 class="font-display text-xl font-semibold text-brand-950">Masuk</h1>
                <p class="mt-1 text-sm text-brand-950/50">Silakan masuk untuk memesan atau mengelola Menu Mahligai Bakery.</p>

                @if (session('status'))
                    <div class="mt-5 rounded-2xl bg-emerald-100 px-4 py-3 text-sm font-semibold text-emerald-700 ring-1 ring-emerald-200">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mt-5 rounded-2xl bg-rose-100 px-4 py-3 text-sm font-semibold text-rose-700 ring-1 ring-rose-200">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('login.submit') }}" method="POST" class="mt-6 space-y-4">
                    @csrf
                    <div>
                        <label for="username" class="text-xs font-semibold text-brand-800">Username</label>
                        <input type="text" id="username" name="username" required value="{{ old('username') }}"
                            autocomplete="username" autofocus
                            class="mt-1.5 w-full rounded-2xl bg-cream-100 px-4 py-3 text-sm text-brand-950 ring-1 ring-brand-950/10 transition placeholder:text-brand-950/35 focus:ring-2 focus:ring-brand-400 focus:outline-none">
                    </div>
                    <div>
                        <label for="password" class="text-xs font-semibold text-brand-800">Kata Sandi</label>
                        <input type="password" id="password" name="password" required autocomplete="current-password"
                            class="mt-1.5 w-full rounded-2xl bg-cream-100 px-4 py-3 text-sm text-brand-950 ring-1 ring-brand-950/10 transition placeholder:text-brand-950/35 focus:ring-2 focus:ring-brand-400 focus:outline-none">
                    </div>
                    <label class="flex items-center gap-2 text-sm text-brand-950/60">
                        <input type="checkbox" name="remember" class="h-4 w-4 accent-brand-600">
                        Ingat saya
                    </label>
                    <button type="submit"
                        class="btn-gradient w-full rounded-full px-6 py-3.5 text-sm font-semibold text-white shadow-lg shadow-brand-600/20">
                        Masuk
                    </button>
                </form>

                <p class="mt-6 text-center text-sm text-brand-950/50">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="font-semibold text-brand-600 hover:text-brand-700">Daftar di sini</a>
                </p>
            </div>

            <p class="mt-6 text-center text-xs text-white/50">
                Mahligai Bakery · Hubungi pemilik bila lupa kata sandi
            </p>
        </div>
    </body>
</html>
@extends('layouts.admin')

@section('title', 'Profil Admin')

@section('content')
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        {{-- Identitas --}}
        <div class="rounded-3xl bg-white p-6 shadow-soft ring-1 ring-brand-950/5">
            <h2 class="text-xs font-bold uppercase tracking-[0.2em] text-brand-600">Identitas</h2>

            @if (session('status'))
                <div class="mt-4 rounded-2xl bg-emerald-100 px-4 py-3 text-sm font-semibold text-emerald-800 ring-1 ring-emerald-200">
                    {{ session('status') }}
                </div>
            @endif

            <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="mt-5 space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label for="name" class="text-xs font-semibold text-brand-800">Nama</label>
                    <input type="text" id="name" name="name" required value="{{ old('name', $admin->name) }}" maxlength="255"
                        class="mt-1.5 w-full rounded-2xl bg-cream-100 px-4 py-3 text-sm text-brand-950 ring-1 ring-brand-950/10 focus:ring-2 focus:ring-brand-400 focus:outline-none">
                    @error('name')
                        <p class="mt-1.5 text-xs font-semibold text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="whatsapp_number" class="text-xs font-semibold text-brand-800">Nomor WhatsApp</label>
                    <input type="text" id="whatsapp_number" name="whatsapp_number" value="{{ old('whatsapp_number', $admin->whatsapp_number) }}" maxlength="20"
                        placeholder="628xxxxxxxxxx"
                        class="mt-1.5 w-full rounded-2xl bg-cream-100 px-4 py-3 text-sm text-brand-950 ring-1 ring-brand-950/10 focus:ring-2 focus:ring-brand-400 focus:outline-none">
                    @error('whatsapp_number')
                        <p class="mt-1.5 text-xs font-semibold text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="avatar" class="text-xs font-semibold text-brand-800">Foto Profil</label>
                    <div class="mt-2 flex items-center gap-4">
                        @if ($admin->avatar_path)
                            <img src="{{ Storage::url($admin->avatar_path) }}" alt="Foto profil" class="h-14 w-14 rounded-full object-cover ring-2 ring-brand-950/10">
                        @else
                            <span class="grid h-14 w-14 place-items-center rounded-full bg-gradient-to-br from-brand-500 to-brand-700 text-lg font-bold text-white">{{ mb_strtoupper(mb_substr($admin->name, 0, 1)) }}</span>
                        @endif
                        <input type="file" id="avatar" name="avatar" accept="image/*"
                            class="block w-full text-sm text-brand-950/70 file:mr-3 file:rounded-full file:border-0 file:bg-brand-600 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white file:transition hover:file:bg-brand-700">
                    </div>
                    @error('avatar')
                        <p class="mt-1.5 text-xs font-semibold text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full rounded-full bg-brand-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-brand-700">
                    Simpan Profil
                </button>
            </form>
        </div>

        {{-- Kata sandi --}}
        <div class="rounded-3xl bg-white p-6 shadow-soft ring-1 ring-brand-950/5">
            <h2 class="text-xs font-bold uppercase tracking-[0.2em] text-brand-600">Ubah Kata Sandi</h2>

            @if (session('password_status'))
                <div class="mt-4 rounded-2xl bg-emerald-100 px-4 py-3 text-sm font-semibold text-emerald-800 ring-1 ring-emerald-200">
                    {{ session('password_status') }}
                </div>
            @endif

            <form action="{{ route('admin.profile.password') }}" method="POST" class="mt-5 space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label for="current_password" class="text-xs font-semibold text-brand-800">Kata Sandi Saat Ini</label>
                    <input type="password" id="current_password" name="current_password" required autocomplete="current-password"
                        class="mt-1.5 w-full rounded-2xl bg-cream-100 px-4 py-3 text-sm text-brand-950 ring-1 ring-brand-950/10 focus:ring-2 focus:ring-brand-400 focus:outline-none">
                    @error('current_password')
                        <p class="mt-1.5 text-xs font-semibold text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="new_password" class="text-xs font-semibold text-brand-800">Kata Sandi Baru</label>
                    <input type="password" id="new_password" name="new_password" required minlength="8" autocomplete="new-password"
                        class="mt-1.5 w-full rounded-2xl bg-cream-100 px-4 py-3 text-sm text-brand-950 ring-1 ring-brand-950/10 focus:ring-2 focus:ring-brand-400 focus:outline-none">
                    @error('new_password')
                        <p class="mt-1.5 text-xs font-semibold text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="new_password_confirmation" class="text-xs font-semibold text-brand-800">Ulangi Kata Sandi Baru</label>
                    <input type="password" id="new_password_confirmation" name="new_password_confirmation" required autocomplete="new-password"
                        class="mt-1.5 w-full rounded-2xl bg-cream-100 px-4 py-3 text-sm text-brand-950 ring-1 ring-brand-950/10 focus:ring-2 focus:ring-brand-400 focus:outline-none">
                </div>
                <button type="submit" class="w-full rounded-full bg-brand-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-brand-700">
                    Ubah Kata Sandi
                </button>
            </form>
        </div>
    </div>
@endsection
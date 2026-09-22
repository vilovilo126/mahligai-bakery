<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\AppNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Halaman login tunggal (username + password) untuk semua pengguna.
     */
    public function showLogin(): RedirectResponse|View
    {
        $user = Auth::user();

        if ($user) {
            return $this->redirectForRole($user);
        }

        return view('auth.login');
    }

    /**
     * Proses login username + password, lalu arahkan sesuai role.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'username' => ['required', 'string', 'max:100'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->boolean('remember');

        if (! Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password']], $remember)) {
            return back()
                ->withErrors(['username' => 'Kredensial tidak valid.'])
                ->withInput($request->only('username'));
        }

        $request->session()->regenerate();

        /** @var User $user */
        $user = Auth::user();

        return $this->redirectForRole($user);
    }

    /**
     * Halaman pendaftaran untuk pelanggan baru (role 'customer').
     */
    public function showRegister(): RedirectResponse|View
    {
        if (Auth::check()) {
            return $this->redirectForRole(Auth::user());
        }

        return view('auth.register');
    }

    /**
     * Buat akun pelanggan baru, langsung login, lalu arahkan ke /menu.
     */
    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'username' => ['required', 'string', 'max:100', 'alpha_dash', 'unique:users,username'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => Str::of($validated['name'])->trim()->title()->toString(),
            'username' => Str::lower($validated['username']),
            'email' => $this->uniqueEmail($validated['username']),
            'password' => $validated['password'],
            'role' => 'customer',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        $user->notify(new AppNotification(
            'Selamat Datang di Mahligai Bakery',
            'Halo '.$user->name.', pesanan Anda sekarang tercatat di akun Anda.',
            route('customer.orders'),
        ));

        return redirect()->route('menu');
    }

    /**
     * Keluar dari semua role: invalidasi sesi + token CSRF, lalu ke '/'.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    private function redirectForRole(User $user): RedirectResponse
    {
        return $user->is_customer
            ? redirect()->route('menu')
            : redirect()->route('admin.dashboard');
    }

    private function uniqueEmail(string $username): string
    {
        $base = Str::lower($username).'@mahligai-bakery.test';

        if (User::where('email', $base)->doesntExist()) {
            return $base;
        }

        $counter = 1;

        do {
            $candidate = $username.'_'.$counter++.'@mahligai-bakery.test';
        } while (User::where('email', $candidate)->exists());

        return $candidate;
    }
}

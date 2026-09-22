<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AdminProfileController extends Controller
{
    /**
     * Tampilkan halaman profil & pengaturan admin.
     */
    public function edit(): View
    {
        /** @var User $admin */
        $admin = Auth::user();

        return view('admin.profile', compact('admin'));
    }

    /**
     * Perbarui identitas profil admin.
     */
    public function update(Request $request): RedirectResponse
    {
        /** @var User $admin */
        $admin = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'whatsapp_number' => ['nullable', 'string', 'max:20'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $data = [
            'name' => $validated['name'],
            'whatsapp_number' => $validated['whatsapp_number'] ?? null,
        ];

        if ($request->hasFile('avatar')) {
            $data['avatar_path'] = $request->file('avatar')->store('avatars', 'public');
        }

        $admin->update($data);

        return back()->with('status', 'Profil berhasil diperbarui.');
    }

    /**
     * Ubah kata sandi admin.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        /** @var User $admin */
        $admin = Auth::user();

        $validated = $request->validate([
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if (! Hash::check($validated['current_password'], $admin->password)) {
            return back()->withErrors(['current_password' => 'Kata sandi saat ini salah.']);
        }

        $admin->update(['password' => $validated['new_password']]);

        return back()->with('password_status', 'Kata sandi berhasil diubah.');
    }
}

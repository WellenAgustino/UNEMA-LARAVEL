<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminUserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Menyimpan user baru ke database.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'full_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:6|confirmed',
            'is_admin' => 'boolean',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error', 'Gagal menambahkan user. Periksa kembali data yang Anda masukkan.');
        }

        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'is_admin' => $request->boolean('is_admin', false),
        ]);

        return back()->with('success', 'User berhasil ditambahkan!');
    }

    /**
     * Memperbarui data user yang ada.
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'full_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6|confirmed',
            'is_admin' => 'boolean',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error', 'Gagal memperbarui user. Periksa kembali data yang Anda masukkan.');
        }

        $data = [
            'username' => $request->username,
            'email' => $request->email,
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'is_admin' => $request->boolean('is_admin', false),
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return back()->with('success', 'User berhasil diperbarui!');
    }

    /**
     * Menghapus user dari database.
     */
    public function destroy(User $user)
    {
        try {
            if ($user->is_admin) {
                return back()->with('error', 'Tidak dapat menghapus akun admin.');
            }

            // Cegah penghapusan user yang sedang login
            if (auth()->id() === $user->id) {
                return back()->with('error', 'Tidak dapat menghapus akun Anda sendiri.');
            }

            $user->delete();
            return back()->with('success', 'User berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error deleting user: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menghapus user.');
        }
    }
}
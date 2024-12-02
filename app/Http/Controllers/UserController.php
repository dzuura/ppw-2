<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->withErrors([
                'email' => 'Please login to access the dashboard.',
            ])->onlyInput('email');
        }
        $users = User::get();
        return view('users')->with('userss', $users);
    }

    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('edit_user', compact('user'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($user->photo) {
                $oldPhotoPath = public_path('storage/' . $user->photo);
                if (File::exists($oldPhotoPath)) {
                    File::delete($oldPhotoPath);
                }
            }

            // Simpan foto baru
            $photoPath = $request->file('photo')->store('photos', 'public');
            $user->photo = $photoPath;
        }

        $user->save();

        return redirect('users')->with('success', 'User  updated successfully');
    }

    public function destroy(string $id)
    {
        $user = User::find($id);
        $file = public_path() . '/storage/' . $user->photo;
        try {
            if (File::exists($file)) {
                File::delete($file);
            }
            $user->delete();
        } catch (\Throwable $th) {
            return redirect('users')->with('error', 'Gagal hapus data');
        }
        return redirect('users')->with('success', 'Berhasil hapus data');
    }
}
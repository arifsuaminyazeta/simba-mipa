<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nim_nip' => ['required', 'string', 'max:30', 'unique:users,nim_nip'],
            'email' => ['required', 'email', 'lowercase', 'max:255', 'unique:users,email'],
            'major' => [
                'required',
                Rule::in(['Ilmu Komputer', 'Matematika', 'Fisika', 'Kimia', 'Biologi']),
            ],
            'phone' => ['nullable', 'string', 'max:30'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'nim_nip.unique' => 'NIM sudah terdaftar.',
            'email.unique' => 'Email sudah digunakan.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'nim_nip' => $request->nim_nip,
            'email' => $request->email,
            'major' => $request->major,
            'phone' => $request->phone,
            'password' => $request->password,
            'role' => 'mahasiswa',
            'academic_status' => 'aktif',
            'is_awardee' => false,
            'is_active' => true,
        ]);

        event(new Registered($user));
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard.mahasiswa');
    }
}
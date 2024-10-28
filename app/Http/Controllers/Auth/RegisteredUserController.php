<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string', 'max:50', 'unique:user,Username'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:user,Email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:50'],
        ]);

        $user = User::create([
            'Username' => $request->username,
            'Email' => $request->email,
            'Password' => Hash::make($request->password),
            'FirstName' => $request->first_name,
            'LastName' => $request->last_name,
            'Role' => 'Teacher', // Default role
            'IsTeacher' => false,
            'IsActive' => true
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}

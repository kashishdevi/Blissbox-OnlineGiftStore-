<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AdminRegisterController extends Controller
{
    /**
     * Show the admin registration form.
     */
    public function showRegisterForm()
    {
        // If already logged in as admin, redirect to dashboard
        if (Auth::check()) {
            $user = Auth::user();
            if (isset($user->is_admin) && $user->is_admin) {
                return redirect()->route('admin.dashboard');
            }
        }
        
        return view('admin.auth.register');
    }

    /**
     * Handle admin registration request.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'is_admin' => true, // Set as admin by default for admin registration
            ]);

            Auth::login($user);

            return redirect()->route('admin.dashboard')->with('success', 'Admin account created successfully!');
        } catch (\Exception $e) {
            return back()->withInput($request->only('name', 'email'))
                ->withErrors(['error' => 'Failed to create admin account. Please make sure the database migration has been run. Error: ' . $e->getMessage()]);
        }
    }
}


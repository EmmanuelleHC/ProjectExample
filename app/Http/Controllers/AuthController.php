<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{
    /**
     * Show login form.
     */
    public function index(): View
    {
        return view('auth.login');
    }

    /**
     * Show registration form.
     */
    public function registration(): View
    {
        return view('auth.registration');
    }

    /**
     * Handle login request.
     */
    public function postLogin(Request $request): RedirectResponse
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        return redirect()->route('dashboard')
                         ->with('success', 'You have successfully logged in!');
    }

    return redirect()->route('login')
                     ->with('error', 'Invalid credentials');
}



    /**
     * Handle registration request.
     */
    public function postRegistration(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        $user = $this->create($request->all());

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Great! You have successfully registered.');
    }

    /**
     * Dashboard page.
     */
    public function dashboard()
{
    if (Auth::check()) {
        return view('dashboard');
    }

    return redirect()->route('login')->with('error', 'Oops! You do not have access.');
}


    /**
     * Create new user.
     */
    protected function create(array $data): User
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * Logout user.
     */
    public function logout(): RedirectResponse
    {
        Session::flush();
        Auth::logout();

        return redirect()->route('login')->with('success', 'You have logged out successfully.');
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Debug logging
        \Log::info('User logged in:', [
            'user_id' => auth()->id(),
            'user_email' => auth()->user()->email,
            'user_role' => auth()->user()->role,
            'intended_url' => session()->get('url.intended')
        ]);

        // Redirect to appropriate dashboard based on user role
        $userRole = auth()->user()->role;
        
        switch ($userRole) {
            case 'kepsek':
                return redirect()->route('kepsek.dashboard');
            case 'admin':
            case 'guru':
            default:
                return redirect()->route('dashboard');
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}

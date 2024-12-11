<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $this->ensureIsNotRateLimited($request);

        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            $request->session()->regenerate();

            RateLimiter::clear($this->throttleKey($request));

            return redirect()->intended('/');
        }

        RateLimiter::hit($this->throttleKey($request));

        throw ValidationException::withMessages([
            'username' => __('auth.failed'),
        ]);
    }

    protected function ensureIsNotRateLimited(Request $request)
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey($request), 3)) {
            return;
        }

        event(new Lockout($request));

        $seconds = RateLimiter::availableIn($this->throttleKey($request));

        throw ValidationException::withMessages([
            'username' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 3600),
            ]),
        ]);
    }

    protected function throttleKey(Request $request)
    {
        return str()->lower($request->input('username')).'|'.$request->ip();
    }
}
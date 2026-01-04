<?php

namespace App\Http\Responses;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request): RedirectResponse
    {
        // Get the intended URL if it exists
        $intended = $request->session()->pull('url.intended', '/cp/dashboard');
        
        // If intended URL is the old dashboard, redirect to admin dashboard
        if ($intended === '/dashboard' || $intended === url('/dashboard')) {
            $intended = '/cp/dashboard';
        }
        
        return redirect($intended);
    }
}


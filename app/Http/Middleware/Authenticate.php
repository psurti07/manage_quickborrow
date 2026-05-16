<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if(!Auth::check()){
            return route('auth');
        }
        
        $user = Auth::user();
        
        // Check if the user is deleted or not active
        if ($user->isDelete == 1) {
            Auth::logout(); // Log the user out
            return route('auth'); // Redirect to login
        }
        
        return $request->expectsJson() ? null : route('auth');
    }
}

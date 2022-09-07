<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Customer
{
    public function handle(Request $request, Closure $next)
    {
        if(!Auth::check()) abort(401, "Unauthenticated: Login first");
        if(!Auth::user()->isCustomer()) abort(403, "Forbidden: You don't have privileges to perform this action");

        return $next($request);
    }
}

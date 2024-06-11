<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VendorAuthetication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $key=null)
    {
        try {
            if ($key === 'register') {
                app(VendorRegisterRequest::class);
            } else if ($key === 'login') {
                app(VendorLoginRequest::class);
            }
            return $next($request);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => $e->errors(),
            ]);
        }
    }
}

<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session as FacadesSession;
use Symfony\Component\HttpFoundation\Response;

class TreeVerification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = FacadesSession::get('tree_verification') ?? null;
//        dd($token);
        $tokenNotExpire = null;
        if ($token) {
            $tokenNotExpire = Carbon::now()->lt($token);
        }

        if ($tokenNotExpire) {
            return $next($request);
        } else {
            $route = Route::getCurrentRoute()->getName();
            return redirect()->route('tree_verification', $route);
        }

    }
}

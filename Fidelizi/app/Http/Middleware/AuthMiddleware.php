<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use Closure;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle( $request, Closure $next)
    {
        $token = $request->bearerToken();
        if(!$token) {
            return response()->json('Acesso não autorizado - token nulo ', 401);
        }
        $user = Admin::query()->where('token', $token)->first();
        if(!$user){
            return response()->json('Acesso negado - rala parceiro', 401);
        }
        return $next($request); 
    }
}

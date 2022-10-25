<?php

namespace App\Http\Middleware;

use App\traits\ResponseTrait;
use Closure;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;

class CheckAdmin
{
    use ResponseTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        $user = null;
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return $this->ErrorResponse('3333', 'Token is Invalid');
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return $this->ErrorResponse('4444', 'Token is Expired');
            } else {
                return $this->ErrorResponse('5555', 'Authorization Token not found');
            }
        }
        if (!$user)
            return $this->ErrorResponse('6666', 'Unauthenticated');
        return $next($request);
    }
}

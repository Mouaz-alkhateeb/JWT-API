<?php

namespace App\Http\Middleware;

use App\traits\ResponseTrait;
use Closure;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtAuthGuard
{
    use ResponseTrait;
    public function handle($request, Closure $next, $guard = null)
    {
        if ($guard != null) {
            auth()->shouldUse($guard); //shoud you user guard / table
            $token = $request->header('token');
            $request->headers->set('token', (string) $token, true);
            $request->headers->set('Authorization', 'Bearer ' . $token, true);
            try {
                //$user = $this->auth->authenticate($request);
                $user = JWTAuth::parseToken()->authenticate();
            } catch (TokenExpiredException) {
                return  $this->ErrorResponse('401', 'Unauthenticated user');
            } catch (JWTException) {
                return  $this->ErrorResponse('3000', 'token_invalid ');
            }
            if (!$user)
                return $this->ErrorResponse('7777', 'Dont have any permision here...!');
        }
        return $next($request);
    }
}

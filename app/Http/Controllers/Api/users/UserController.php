<?php

namespace App\Http\Controllers\Api\users;

use App\Http\Controllers\Controller;
use App\traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    use ResponseTrait;
    public function login(Request $request)
    {

        try {
            $rules = [
                "email" => "required",
                "password" => "required"
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            $credentials = $request->only(['email', 'password']);
            $token = Auth::guard('user_api')->attempt($credentials);
            if (!$token)
                return $this->ErrorResponse('E001', 'بيانات الدخول غير صحيحة');
            $user = Auth::guard('user_api')->user();
            $user->user_token = $token;
            return $this->SuccesResponse('888', 'معلومات المستخدم ', 'user', $user);
        } catch (Exception $ex) {
            return $this->ErrorResponse($ex->getCode(), $ex->getMessage());
        }
    }
    public function logout(Request $request)
    {
        $token = $request->header('token');
        if ($token) {
            try {
                JWTAuth::setToken($token)->invalidate();
            } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return $this->ErrorResponse('600', 'Exception Error..!');
            }
            return $this->changeStatus('200', 'Logout successfully..!');
        } else {
            return $this->ErrorResponse('400', 'Logout failed..!');
        }
    }
}

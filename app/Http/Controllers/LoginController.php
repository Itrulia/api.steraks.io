<?php namespace App\Http\Controllers;

use App\Http\Requests\Auth\Login;
use App\Http\Requests\Auth\Logout;
use App\User;
use JWTAuth;
use Illuminate\Contracts\Auth\Guard;

class LoginController extends Controller
{
    /**
     * @param \App\Http\Requests\Auth\Login $request
     * @param \Illuminate\Contracts\Auth\Guard $guard
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Login $request, Guard $guard)
    {
        $credentials = $request->only('email', 'password');
        $token = JWTAuth::attempt($credentials);

        if (!$token) {
            $errors = [];
            $user = User::whereEmail($credentials['email'])->count();

            $errors['password'] = trans('failed');

            if ($user === 0) {
                $errors['email'] = trans('email_not_found');
            }

            return response()->json($errors, 422);
        }

        return response()->json($guard->user());
    }

    /**
     * @param \App\Http\Requests\Auth\Logout $request
     * @param \Illuminate\Contracts\Auth\Guard $guard
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Logout $request, Guard $guard)
    {
        $guard->logout();

        return response()->json([]);
    }
}

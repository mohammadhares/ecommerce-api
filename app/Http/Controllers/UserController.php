<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class UserController extends Controller
{
    // User registration
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|',
            'role' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'role' => $request->get('role'),
            'password' => Hash::make($request->get('password')),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user', 'token'), 201);
    }

    // User login
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response($validator->errors()->toJson(), 400);
        }

        $user = User::where('email', $request['email'])->first();
        if (!$user) {
            return response()->json(['error' => 'Invalid credintial'], 400);
        }else{
            if(Hash::check($request['password'], $user->password)){
                $token = JWTAuth::fromUser($user);
                if (!$token) {
                    return response(['error' => 'Invalid credintial'], 401);
                }
                return response([
                    'user' => $user,
                    'token' => $token,
                ], 200);
            }else{
                return response()->json(['error' => 'Invalid credintial'], 400);
            }
        }
    }


    // Forgot Password
    public function forgotPassword(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'email' => 'required|email|exists:users,email',
        // ]);

        // if ($validator->fails()) {
        //     return response()->json($validator->errors(), 400);
        // }

        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json(['message' => 'Password reset link sent successfully.']);
        } else {
            return response()->json(['error' => 'Failed to send password reset link.'], 500);
        }
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return response()->json(['message' => 'Password has been reset successfully.']);
        } else {
            return response()->json(['error' => 'Failed to reset password.'], 500);
        }
    }

    // Get authenticated user
    public function me()
    {
        return response()->json(Auth::guard('api')->user());
    }


    // User logout
    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json(['message' => 'Successfully logged out']);
    }
}

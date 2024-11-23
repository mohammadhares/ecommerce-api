<?php

namespace App\Http\Controllers;

use App\Mail\ForgetPassword;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
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
        $validator = Validator::make($request->all(), [
            'email' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $email = User::Where('email', $request['email'])->first();

        if (!$email) {
            return response()->json(['error' => 'Email not found'], 400);
        }

        // generate code 6 digits for reset password
        $code = rand(100000, 999999);
        DB::table('verify_code')->insert([
            'code' => $code,
            'expiration' => time() + 22,
        ]);

        $data = [
            'code' => $code,
        ];

        try {
            Mail::to($request['email'])->send(new ForgetPassword($data));
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Email sending failed.',
                'error' =>  $e->getMessage(),
            ], 200);
        }

        return response([
           'message' => 'Password reset code sent successfully.',
        ], 200);
    }

    public function CheckResetCode(Request $request)
    {
        $code = $request['code'];
        $verify_code = DB::table('verify_code')->where('code', $code)->get();
        if(count($verify_code) > 0){
            return response([
               'message' => 'Password reset code is valid.',
            ], 200);
        }else{
            return response([
               'message' => 'Invalid password reset code.',
            ], 400);
        }
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = DB::table('users')->where('email', '=', $request->email)->update([
            'password' => Hash::make($request->password)
        ]);
        if($user){
            return response([
               'message' => 'Password reset successfully.',
            ], 200);
        }else{
            return response([
               'message' => 'Failed to reset password.',
            ], 400);
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

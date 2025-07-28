<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{

    public function register(Request $request, $guard)
    {
        if (!in_array($guard, ['admin', 'user'])) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid guard'
            ], Response::HTTP_BAD_REQUEST);
        }

        $table = Str::plural($guard);

        $validator = validator($request->all(), [
            'name' => "required|string",
            'email' => "required|email|unique:$table,email",
            'password' => "required|string",
        ]);

        if (!$validator->fails()) {
            if ($guard == 'admin') {
                $admin = new Admin();
                $admin->name = $request->input("name");
                $admin->email = $request->input("email");
                $admin->password = Hash::make($request->input("password"));
                $saved = $admin->save();
                return response()->json([
                    'status' => $saved,
                    'message' => $saved ? 'Created Account Sccessfully' : 'Created Account Failed',
                ], Response::HTTP_CREATED);
            } else {
                $user = new User();
                $user->name = $request->input("name");
                $user->email = $request->input("email");
                $user->password = Hash::make($request->input("password"));
                $saved = $user->save();
                return response()->json([
                    'status' => $saved,
                    'message' => $saved ? 'Created Account Sccessfully' : 'Created Account Failed',
                ], Response::HTTP_CREATED);
                ;
            }

        }
        return response()->json([
            'status' => false,
            'message' => $validator->getMessageBag()->first()
        ], Response::HTTP_BAD_REQUEST);

    }


    public function sendResetEmail(Request $request, $guard)
    {
        session()->put(['guard' => $guard]);

        $broker = Str::plural(session('guard'));
        $validator = validator($request->all(), [
            'email' => "required|email|exists:$broker,email"
        ]);

        if (!$validator->fails()) {
            $status = Password::broker($broker)->sendResetLink($request->only('email'));
            return $status == Password::RESET_LINK_SENT
                ? response()->json(['status' => true, 'message' => __($status)])
                : response()->json(
                    ['status' => false, 'message' => __($status)],
                    Response::HTTP_BAD_REQUEST
                );
        } else {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()->first(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function resetPassword(Request $request, $guard)
    {
        session()->put(['guard' => $guard]);
        $validator = validator(
            $request->all()
        );
        if (!$validator->fails()) {
            $broker = Str::plural($guard);
            $status = Password::broker($broker)->reset($request->all(), function ($user, $password) {
                $user->forceFill(['password' => Hash::make($password)]);
                $user->save();
                event(new PasswordReset($user));
            });
            return $status == Password::PASSWORD_RESET
                ? response()->json(['status' => true, 'message' => __($status)])
                : response()->json(['status' => false, 'message' => __($status)], Response::HTTP_BAD_REQUEST);
        } else {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()->first(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function login(Request $request, $guard)
    {
        if (!in_array($guard, ['admin', 'user'])) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid guard'
            ], Response::HTTP_BAD_REQUEST);
        }

        $table = Str::plural($guard);

        $validator = validator($request->all(), [
            'email' => "required|email|exists:$table,email",
            'password' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }

        $model = $guard === 'admin' ? Admin::class : User::class;
        $user = $model::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Login failed, error credentials'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $token = $user->createToken("$guard-token")->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Logged in successfully',
            'token' => $token,
            'user' => $user
        ], Response::HTTP_OK);

    }

    public function logout(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not authenticated'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $user->currentAccessToken()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Logged out successfully'
        ], Response::HTTP_OK);
    }

}

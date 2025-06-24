<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Psy\Readline\Hoa\Console;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showRegister(Request $request)
    {
        return view("auth.register");
    }

    public function register(Request $request)
    {
        $validator = validator($request->all(), [
            'name' => "required|string",
            'email' => "required|email",
            'password' => "required|string",
        ]);

        if (!$validator->fails()) {
            $admin = new Admin();
            $admin->name = $request->input("name");
            $admin->email = $request->input("email");
            $admin->password = Hash::make($request->input("password"));
            $saved = $admin->save();
            return redirect()->route("admin.login.show")
            ->with([
                "status" => $saved,
                'message' => $saved ? 'Created Account Sccessfully' : 'Created Account Failed',
            ]);

        }


    }

    public function showLogin(Request $request)
    {
        return view("auth.login");
    }

    public function login(Request $request)
    {
        // $table = Str::plural(session('guard'));

        $validator = validator($request->all(), [
            'email' => "required|email|exists:admins,email",
            'password' => 'required|string',
            'remember_me' => 'required|boolean'
        ]);
        if (!$validator->fails()) {
            if (Auth::guard(session('guard'))->attempt($request->only(['email', 'password']), $request->input('remember_me'))) {
                return response()->json([
                    'message' => 'Login in successfully'
                ], Response::HTTP_OK);
            } else {
                return response()->json([
                    'message' => 'Login failed, error credentials'
                ], Response::HTTP_BAD_REQUEST);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function logout(Request $request)
    {
        auth('admin')->logout();
        $request->session()->invalidate();
        session()->remove('session');
        return redirect()->route('admin.login.show');
    }
}

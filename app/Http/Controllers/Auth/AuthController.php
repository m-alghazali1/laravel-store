<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Psy\Readline\Hoa\Console;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showRegister(Request $request, $guard)
    {
        $validator = validator(['guard' => $guard], [
            'guard' => 'required|string|in:admin,user'
        ]);
        if (!$validator->fails()) {
            session()->put('guard', $guard);
            return view("auth.register", compact('guard'));
        }
        abort(Response::HTTP_FORBIDDEN, 'URL Rejected');
    }

    public function register(Request $request)
    {
        $validator = validator($request->all(), [
            'name' => "required|string",
            'email' => "required|email",
            'password' => "required|string|confirmed",
            'guard' => 'required|in:admin,user'
        ]);
        $guard = $request->input('guard');
        if (!$validator->fails()) {

            if ($guard === 'admin') {
                $admin = new Admin();
                $admin->name = $request->input("name");
                $admin->email = $request->input("email");
                $admin->password = Hash::make($request->input("password"));
                $saved = $admin->save();
            } else {
                $user = new User();
                $user->name = $request->input("name");
                $user->email = $request->input("email");
                $user->password = Hash::make($request->input("password"));
                $saved = $user->save();
            }

            return response()->json([
                'status' => true,
                'message' => 'Created Account Successfully',
                'redirect_url' => route("auth.login.show", ['guard' => $guard]),
            ], Response::HTTP_CREATED);;
        }
        return response()->json([
            'status' => false,
            'message' => $validator->getMessageBag()->first()
        ], Response::HTTP_BAD_REQUEST);
    }

    public function showLogin(Request $request, $guard)
    {
        $validator = validator(['guard' => $guard], [
            'guard' => 'required|string|in:admin,user'
        ]);
        if (!$validator->fails()) {
            session()->put('guard', $guard);
            return response()->view('auth.login');
        }
        abort(Response::HTTP_FORBIDDEN, 'URL Rejected');
    }

    public function login(Request $request)
    {
        $table = Str::plural(session('guard'));

        $validator = validator($request->all(), [
            'email' => "required|email|exists:$table,email",
            'password' => 'required|string',
            'remember_me' => 'required|boolean'
        ]);

        $guard = session('guard');
        if (!$validator->fails()) {
            if (Auth::guard(session('guard'))->attempt($request->only(['email', 'password']), $request->input('remember_me'))) {
                $defaultRedirectUrl = $guard === 'admin'
                    ? route('admin.products.index')
                    : route('products.index');

                return response()->json([
                    'redirect_url' => $defaultRedirectUrl,
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
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('auth.login.show', ['guard' => 'admin']);
        }

        if (Auth::guard('user')->check()) {
            Auth::guard('user')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('auth.login.show', ['guard' => 'user']);
        }

        return redirect('/');
    }

}

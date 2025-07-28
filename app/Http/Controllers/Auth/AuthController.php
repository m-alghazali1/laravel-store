<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Psy\Readline\Hoa\Console;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showRegister(Request $request, $guard)
    {
        $validator = validator(['guard' => $guard], [
            'guard' => 'required|string|in:admin,user,vendor',
        ]);
        if (!$validator->fails() && $guard === 'vendor') {
            session()->put('guard', $guard);
            return view("admin.vendors.register", compact('guard'));
        }
        if (!$validator->fails()) {
            session()->put('guard', $guard);
            return view("auth.register", compact('guard'));
        }
        abort(Response::HTTP_FORBIDDEN, 'URL Rejected');
    }

    public function register(Request $request)
    {
        $guard = $request->input('guard');
        $rules = [
            'name' => 'required|string',
            'email' => "required|email|unique:{$guard}s,email",
            'password' => 'required|string|confirmed',
            'guard' => 'required|in:admin,user,vendor',
        ];

        if ($guard === 'vendor') {
            $rules['phone'] = 'required|string|max:15';
            $rules['address'] = 'required|string|max:255';
            $rules['logo'] = 'nullable|image|mimes:jpeg,png,jpg|max:2048';
        }

        $validator = validator($request->all(), $rules);

        $guard = $request->input('guard');
        if (!$validator->fails()) {

            if ($guard === 'admin') {
                $admin = new Admin();
                $admin->name = $request->input("name");
                $admin->email = $request->input("email");
                $admin->password = Hash::make($request->input("password"));
                $saved = $admin->save();

                $admin->assignRole('Super Admin');
            }
            if ($guard === 'user') {
                $user = new User();
                $user->name = $request->input("name");
                $user->email = $request->input("email");
                $user->password = Hash::make($request->input("password"));
                $saved = $user->save();

                $user->assignRole('Customer');
            }
            if ($guard === 'vendor') {
                $vendor = new Vendor();
                $vendor->name = $request->input("name");
                $vendor->email = $request->input("email");
                $vendor->phone = $request->input("phone");
                $vendor->address = $request->input("address");
                if ($request->hasFile('logo')) {
                    $logo = $request->file('logo');
                    $logoPath = $logo->store('logos', 'public');
                    $vendor->logo = $logoPath;
                }
                $vendor->password = Hash::make($request->input("password"));
                $saved = $vendor->save();

                $vendor->assignRole('Store Owner');
            }

            return response()->json([
                'status' => true,
                'message' => 'Created Account Successfully',
                'redirect_url' => route("auth.login.show", ['guard' => $guard]),
            ], Response::HTTP_CREATED);
            ;
        }
        return response()->json([
            'status' => false,
            'message' => $validator->getMessageBag()->first()
        ], Response::HTTP_BAD_REQUEST);
    }
    public function forgotPassword(Request $request, $guard)
    {
        session()->put(['guard' => $guard]);

        return response()->view('auth.forgot-password');
    }

    public function sendResetEmail(Request $request, $guard)
    {
        session()->put(['guard' => $guard]);

        $broker = Str::plural(session('guard'));
        $validator = validator($request->all(), [
            'email' => "required|email|exists:$broker,email"
            // 'email' => 'required|email'
        ]);

        if (!$validator->fails()) {
            $status = Password::broker($broker)->sendResetLink($request->only('email'));
            return $status == Password::RESET_LINK_SENT
                ? response()->json(['status' => true, 'message' => __($status)])
                : response()->json(['status' => false, 'message' => __($status)], Response::HTTP_BAD_REQUEST);
        } else {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()->first(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function showResetPassword(Request $request, $token)
    {
        return response()->view('auth.recover-password', [
            'token' => $token,
            'email' => $request->input('email'),
            'guard' => session('guard')
        ]);
    }

    public function resetPassword(Request $request, $guard)
    {
        session()->put(['guard' => $guard]);
        $validator = validator($request->all(), [
            'token' => 'required',
            'email' => 'required|email|exists:password_reset_tokens,email',
            'password' => ['required', 'string', 'confirmed']
        ]);
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

    public function showVerifyEmail()
    {
        return response()->view('auth.verify-email');
    }

    public function requestEmailverification(Request $request)
    {
        $guard = session('guard');
        $request->user($guard)->sendEmailVerificationNotification();
        return response()->json([
            'status' => true,
            'message' => 'Verification link sent to your email'
        ], Response::HTTP_OK);
    }

    public function verifiyEmail(EmailVerificationRequest $emailVerificationRequest)
    {
        $emailVerificationRequest->fulfill();
        $guard = session('guard');
        if ($guard === '' || $guard === 'null') {
            return response()->json([
                'status' => false,
                'message' => 'Invalid guard'
            ]);
        }
        if ($guard === 'admin') {
            return redirect()->route('admin.products.index');
        } else {
            return redirect()->route('products.index');
        }
    }
    public function showLogin(Request $request, $guard)
    {
        $validator = validator(['guard' => $guard], [
            'guard' => 'required|string|in:admin,user,vendor',
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
        // dd($table);
        $validator = validator($request->all(), [
            'email' => "required|email|exists:$table,email",
            'password' => 'required|string',
            'remember_me' => 'required|boolean'
        ]);

        $guard = session('guard');
        if (!$validator->fails()) {
            if (Auth::guard(session('guard'))->attempt($request->only(['email', 'password']), $request->input('remember_me'))) {
                $defaultRedirectUrl = $guard === 'admin' || $guard === 'vendor'
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
        $guard = session('guard');
        auth($guard)->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('auth.login.show', ['guard' => $guard]);
    }

}

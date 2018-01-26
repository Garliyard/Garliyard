<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\TOTP;
use App\User;
use App\Yubikey;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function loginView()
    {
        return (Auth::check()) ? redirect("/home") : view("auth/login");
    }

    public function login(Request $request)
    {
        if ($error = $this->manualValidation($request)) return view("auth/login")->with("error", $error);

        $auth_array = [
            "username" => $request->input("username"),
            "password" => $request->input("password")
        ];

        if (Auth::attempt($auth_array)) {
            // Check to see if the user has a yubikey or TOTP secret associated to their account

            if (Yubikey::userHasYubikeys()) {
                // They do - lock them in a session
                session()->push("yubikey-needed", "true");

                // Return the redirect to the view.
                return redirect("/login/yubikey");

            } elseif (TOTP::doesUserHaveSecret()) {

                // They do - lock them in a session
                session()->push("totp-needed", "true");

                // Return the redirect to the view.
                return redirect("/login/totp");

            } else {
                // They don't, let them continue.
                User::welcome();
                return redirect("/home");
            }
        } else {
            session()->flash("error", "Invalid username or password");
            return view("auth/login")
                ->with("username", ($request->has("username") ? $request->input("username") : ""));
        }

    }

    public function manualValidation(Request $request)
    {
        if (!$request->has("username")) return "Please provide a valid username";
        if (!$request->has("password")) return "Please provide a valid password";
        return false;
    }

    public function logout()
    {
        if (Auth::check()) {
            session()->flush();
            Auth::logout();
        };
        return redirect("/");
    }
}



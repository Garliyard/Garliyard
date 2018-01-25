<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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

        if (Auth::attempt(["username" => $request->input("username"), "password" => $request->input("password")])) {
            // Check to see if the user has a yubikey associated to their account

            if (Yubikey::userHasYubikeys()) {
                // They do - lock them in a session
                session()->push("yubikey-needed", "true");

                // Return the redirect to the view.
                return redirect("/login/yubikey");
            } else {
                // They don't, let them continue.
                return redirect("/home");
            }
        } else {
            return view("auth/login")
                ->with("username", ($request->has("username") ? $request->input("username") : ""))
                ->with("error", "Invalid username or password");
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

    public function yubikeyAuthView()
    {
        return view("auth/yubikey");
    }

    public function yubikeyAuthPost(Request $request)
    {
        $yubikey = new YubikeyController();

        // Check to see if the yubikey is needed to authorize, if not then just redirect them away
        if (session()->has("yubikey-needed")) {

            // Okay, it's needed, check to see if the passed key is valid
            if ($yubikey->valid($request->input("yubikey"))) {

                // The key is valid, check to see if the user owns it
                if (Yubikey::doesUserOwnKey($yubikey->getIdentity($request->input("yubikey")))) {

                    // The yubikey belongs to the user - log them in
                    session()->forget("yubikey-needed");
                    return redirect("/home");

                } else {

                    // The yubikey isn't associated to their account.
                    session()->flash("error", "This yubikey does not belong to your account");

                    // Return the view.
                    return view("auth/yubikey");

                }
            } else {

                // Invalid Token
                session()->flash("error", "Invalid OTP Token, please try again.");

                // Return the view.
                return view("auth/yubikey");

            }
        } else {

            // The user does not belong here, take them to the login, which will then redirect them again.
            return redirect("/login");

        }
    }
}



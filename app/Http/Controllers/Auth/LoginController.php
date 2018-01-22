<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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
            return redirect("/home");
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
    }

    public function logout()
    {
        if (Auth::check()) Auth::logout();
        return redirect("/");
    }
}

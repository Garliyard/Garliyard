<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    public function register(Request $request)
    {
        if ($error = $this->manualValidation($request)) return view("auth/register")->with("error", $error);
        $user = User::create([
            "username" => $request->input("username"),
            "password" => bcrypt($request->input("password"))
        ]);
        Auth::login($user);
        return redirect("/home");
    }

    private function manualValidation(Request $request)
    {
        if (!$request->has("username")) return "Please provide a valid username";
        if (!$request->has("password")) return "Please provide a valid password";
        if (User::where('username', $request->input("username"))->first()) return "Username already exists";
        return false;
    }

    public function registrationView()
    {
        return view("auth/register");
    }
}

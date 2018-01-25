<?php
/**
 * Created by PhpStorm.
 * User: elyci
 * Date: 1/25/2018
 * Time: 1:04 PM
 */

namespace App\Http\Controllers\Auth;


use App\User;
use App\Yubikey;
use Illuminate\Http\Request;

class TwoFactorController
{
    private $yubikey;

    public function __construct()
    {
        $this->yubikey = new YubikeyController();
    }

    public function accountTwoFactorIndex()
    {
        if ($need = $this->additionalAuthNeeded()) return $need;

        return view("dashboard/account/2fa/index")
            ->with("yubikeys", Yubikey::getUserKeys());
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
                    User::welcome();
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
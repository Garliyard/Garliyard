<?php
/**
 * Created by PhpStorm.
 * User: elyci
 * Date: 1/25/2018
 * Time: 1:04 PM
 */

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\DashboardController;
use App\User;
use App\Yubikey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TwoFactorController extends DashboardController
{
    private $yubikey;

    public function __construct()
    {
        $this->yubikey = new YubikeyController();
    }

    /**
     * Two Factor View
     *
     * The root of the two factor authentication, in view form.
     *
     * @return $this|bool|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function accountTwoFactorIndex()
    {
        if ($need = $this->additionalAuthNeeded()) return $need;

        return view("dashboard/account/2fa/index")
            ->with("yubikeys", Yubikey::getUserKeys());
    }

    /**
     * Yubikey Authentication View
     *
     * Return the page where the yubikey is requested
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function yubikeyAuthView()
    {
        return view("auth/yubikey");
    }

    /**
     * Yubikey Auth Post
     *
     * The function that will verify if the yubikey token is valid.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
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

    /**
     * Deauthorize Yubikey
     *
     * Deauthorizes the yubikey from the user's account.
     *
     * @param $yubikey
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function deauthorizeYubikey($yubikey)
    {
        if (Yubikey::doesUserOwnKey($yubikey)) {
            Yubikey::where([
                "user_id" => Auth::user()->id,
                "yubikey_identity" => $yubikey
            ])->delete();
            session()->flash("success", sprintf("The Yubikey '%s' has successfully been removed from your account.", $yubikey));
            return redirect("/account/2fa");
        } else {
            return abort(404);
        }
    }

    /**
     * Add Yubikey View
     *
     * The view that allows the user to add their yubikey to their account
     *
     * @return bool|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function addYubikeyView()
    {
        if ($need = self::additionalAuthNeeded()) return $need;

        return view("dashboard/account/2fa/add_yubikey");
    }

    /**
     * Add Yubikey Post
     *
     * The internal function that verifies the key and adds it to their user account.
     *
     * @param Request $request
     * @return bool|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function addYubikey(Request $request)
    {
        $yubikey = new YubikeyController();

        if ($need = self::additionalAuthNeeded()) return $need;

        if ($yubikey->valid($request->input("yubikey"))) {

            if (!Yubikey::doesUserOwnKey($yubikey->getIdentity())) {
                Yubikey::create([
                    "user_id" => Auth::user()->id,
                    "yubikey_identity" => $yubikey->getIdentity()
                ]);

                session()->flash("success", "Your Yubikey was successfully verified with Yubico - You will now require it to login.");
                return redirect("/account/2fa");
            } else {
                session()->flash("error", "The Yubikey you provided is already authorized to your account.");
                return redirect("/account/2fa");
            }
        } else {
            session()->flash("error", "OTP Token was invalid - please try again.");
            return redirect("/account/2fa/yubikey/add");
        }
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: elyci
 * Date: 1/25/2018
 * Time: 11:19 AM
 */

namespace App\Http\Controllers\Auth;


use Illuminate\Routing\Controller;
use Yubikey\Validate;

class YubikeyController extends Controller
{
    // Placeholder class to inherit the validator.
    private $validate_class;

    // API Identification.
    private $identity_number;
    private $identity_secret;

    // Mutable variables that will be ued to store data.
    private $last_result;
    private $otp;


    /**
     * YuibkeyController constructor.
     * @param null $id
     * @param null $secret
     */
    public function __construct($id = null, $secret = null)
    {
        //Determine if we should use the inheritance passed variables or the env.
        $this->identity_number = ($id) ? $id : config('app.yubikey_id');
        $this->identity_secret = ($secret) ? $secret : config('app.yubikey_secret');

        //Initialize the validation class.
        $this->validate_class = new Validate($this->identity_secret, $this->identity_number);
    }


    /**
     * Is Valid?
     *
     * Checks to see if the OTP Token passed is valid.
     *
     * @param $otp
     * @return mixed
     */
    public function valid($otp)
    {
        //Store the OTP for future reference.
        $this->otp = $otp;
        //Determine if the OTP is valid.
        $this->last_result = $this->validate_class->check($otp);
        return $this->last_result->success();
    }

    public function getIdentity()
    {
        return substr($this->otp, 0, 12);
    }
}
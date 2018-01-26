<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;


class TOTP extends Model
{
    protected $table = "google_authenticator_totp";

    protected $fillable = [
        "user_id",
        "secret"
    ];

    public function getSecret()
    {
        return Crypt::decrypt($this->secret);
    }

    public static function getUserSecret()
    {
        return Crypt::decrypt(self::where('user_id', Auth::user()->id)->first()->secret);
    }

    public static function doesUserHaveSecret()
    {
        return self::where('user_id', Auth::user()->id)->first();
    }
}


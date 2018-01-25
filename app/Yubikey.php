<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Yubikey extends Model
{
    protected $fillable = [
        "user_id",
        "name",
        "yubikey_identity"
    ];

    public static function userHasYubikeys()
    {
        return self::getUserKeys()->count() != 0;
    }

    public function getOwner()
    {
        return User::where('user_id', $this->user_id)->first();
    }

    public static function getUserKeys()
    {
        return self::where('user_id', Auth::user()->id)->get();
    }

    public static function doesUserOwnKey($key)
    {
        return self::where('yubikey_identity', $key)->first();
    }
}

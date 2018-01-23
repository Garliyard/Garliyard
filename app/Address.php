<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class Address extends Model
{
    protected $table = "addresses";

    protected $fillable = [
        "user_id",
        "address",
        "label"
    ];

    /**
     * Get Owner ID by address
     *
     * Returns the address owner's ID
     *
     * @param $address
     * @return mixed
     */
    public static function getOwnerID($address): int
    {
        return self::where('address', $address)->firstOrFail()->user_id;
    }

    /**
     * Get Total Address Count
     *
     * @return mixed
     */
    public static function getCount(): int
    {
        return Cache::tags('address-count')->remember('total', 10, function () {
            return self::all()->count();
        });
    }

    public static function getUserCount()
    {
        return Cache::tags('address-count')->remember(Auth::user()->username, 5, function () {
            return self::where('user_id', Auth::user()->id)->get()->count();
        });
    }

}

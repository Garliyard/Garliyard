<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Address extends Model
{
    protected $table = "addresses";

    protected $fillable = [
        "user_id",
        "address",
        "balance"
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
        return Cache::remember('total-address-count', 10, function () {
            return self::all()->count();
        });
    }

}

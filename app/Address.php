<?php

namespace App;

use App\Http\Controllers\GarlicoinController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;

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
        return self::where('user_id', Auth::user()->id)->get()->count();
    }

    public static function getReceived($address)
    {
        $gcd = new GarlicoinController();
        return Cache::tags('address-received')->remember($address, 3, function () use ($gcd, $address) {
            return $gcd->getAddressBalance($address);
        });
    }

    public function getLabel()
    {
        try {
            return Crypt::decrypt($this->label);
        } catch (\Exception $exception) {
            return $this->label;
        }
    }

}

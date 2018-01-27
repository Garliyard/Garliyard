<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get Total User Count
     *
     * @return mixed
     */
    public static function getCount()
    {
        return Cache::remember('total-user-count', 10, function () {
            return self::all()->count();
        });
    }

    public static function welcome()
    {
        session()->flash("warning", sprintf("Welcome Back, %s! %s", Auth::user()->username, env("MOTD", "")));
    }

    private static $currency_location_array = [
        "USD" => [
            "US", "CA"
        ],
        "EUR" => [
            "FR", "DE", "NO", "GB", "SE"
        ]
    ];

    public static function getCurrency()
    {
        $user_country_code = self::getCountryCode();
        foreach (self::$currency_location_array as $currency => $countries) {
            foreach ($countries as $country) if ($country == $user_country_code) return $currency;
        }
        return "USD"; // Default Currency
    }

    public static function getCountryCode()
    {
        return (isset($_SERVER["HTTP_CF_IPCOUNTRY"])) ? $_SERVER["HTTP_CF_IPCOUNTRY"] : self::resolveCountryCodeFromIpAddress();
    }

    public static function resolveCountryCodeFromIpAddress()
    {
        $ip = self::getIPAddress();
        return Cache::tags('country-code-resolver')->remember($ip, 86400, function () use ($ip) {
            $resolver_data = json_decode(file_get_contents(sprintf("https://ipinfo.io/75.44.102.253/json", $ip)), true);
            return (isset($resolver_data["country"])) ? $resolver_data["country"] : "US";
        });
    }

    public static function getIPAddress()
    {
        return (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) ? $_SERVER["HTTP_CF_CONNECTING_IP"] : $_SERVER["REMOTE_ADDR"];
    }
}

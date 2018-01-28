<?php

namespace App\Http\Controllers;

use App\Address;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Cache;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        return view("index");
    }

    public function isAppEnvironmentLocal()
    {
        return env("APP_ENV", "production") == "local";
    }

    public function qr($address)
    {
        return response(QrCode::format('png')->size(500)->generate($address), 200, [
            "Content-Type" => "image/png"
        ]);
    }

    public static function getServerBalanceGetter()
    {
        return Cache::remember('server-balance', 10, function () {
            $gc = new GarlicoinController();
            return $gc->getServerBalance();
        });
    }

    public static function shouldDisplayDonation()
    {
        $gc = new GarlicoinController();
        $exchange_rate =  $gc->exchangeRate();
        $donation_address_value = floatval(Address::getReceived(env('DONATION_ADDRESS')));
        $donation_address_received_usd = $donation_address_value * $exchange_rate;
        return $donation_address_received_usd < floatval('DONATION_NEEDED');
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
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

    public function qr($address) {
        return response(QrCode::format('png')->size(500)->generate($address), 200, [
            "Content-Type" => "image/png"
        ]);
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: elyci
 * Date: 1/27/2018
 * Time: 12:55 PM
 */

namespace App\Http\Controllers;


class APIController extends Controller
{
    private $garlicoin;

    public function __construct()
    {
        $this->garlicoin = new GarlicoinController();
    }


    public function getExchangeRateUSD()
    {
        return $this->garlicoin->exchangeRate();
    }

    public function getExchangeRateUSDJSON()
    {
        return json_encode([
            "usd" => $this->garlicoin->exchangeRate()
        ], JSON_PRETTY_PRINT);
    }
}
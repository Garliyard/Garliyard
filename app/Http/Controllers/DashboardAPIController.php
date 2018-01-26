<?php
/**
 * Created by PhpStorm.
 * User: elyci
 * Date: 1/26/2018
 * Time: 6:34 PM
 */

namespace App\Http\Controllers;


class DashboardAPIController extends DashboardController
{
private $garlicoin;

    public function __construct()
    {
        $this->middleware("auth");
        $this->garlicoin = new GarlicoinController();
    }

    public function getBalance()
    {
        return response(json_encode([
            "value" => $this->garlicoin->getBalance()
        ]));
    }
}
<?php

namespace App\Http\Controllers;

use App\Address;
use App\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class GarlicoinController extends JsonRpcController
{
    /**
     * GarlicoinController constructor.
     */
    public function __construct()
    {
        $this->middleware("auth");
    }

    /**
     * Get New Address
     *
     * Contacts the garlicoin daemon to create a new address for the user and stores it in the database.
     *
     * This utilizes the redis cache as a form of rate limiting.
     *
     * @return mixed
     */
    public function getNewAddress()
    {
        if (Cache::tags('new-address')->has(Auth::user()->username)) {
            session("notice")->flash("Creating a new address takes space! - Please wait a minute before creating a new address.");
            return Cache::tags('new-address')->get(Auth::user()->username);
        } else {
            $this->newRequest();
            $this->setMethod("getnewaddress");
            $this->setParameters([Auth::user()->username]); // [username]
            $this->newCurlInstance();
            $data = $this->post();

            if ($data["status"] == "success") {
                return Address::create([
                    "user_id" => Auth::user()->id,
                    "address" => $data["result"]
                ]);
            } else {
                return ($this->isAppEnvironmentLocal()) ? dd($data) : false;
            }
        }
    }

    /**
     * Get List of Addresses
     *
     * Returns all of the user's addresses.
     *
     * This does utilize the redis cache to prevent large database requests.
     *
     * @return Address
     */
    public function getListOfAddresses(): Address
    {
        return Cache::tags('addresses')->remember(Auth::user()->username, 3, function () {
            return Address::where('user_id', Auth::user()->id)->get();
        });
    }

    /**
     * Get Last Address
     *
     * Returns the last address in the database to be created by the user.
     *
     * @return Address
     */
    public function getLastAddress(): Address
    {
        return ($last = Address::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->first()) ? $last : $this->getNewAddress();
    }

    /**
     * Pay User
     *
     * Will deduct a balance from the logged in user's account and pay the $address $amount
     *
     * @param string $address
     * @param float $amount
     * @return Transaction|bool
     */
    public function pay(string $address, float $amount)
    {
        if ($this->hasEnough($amount)) {
            $this->newRequest();
            $this->setMethod("sendfrom");
            $this->setParameters([Auth::user()->username, $address, $amount, 6]); // [from_account, to_address, amount, minconf]
            $this->newCurlInstance();
            $data = $this->post();

            if ($data["status"] == "success") {
                return Transaction::create([
                    "user_id" => Auth::user()->id,
                    "transaction_id" => $data["transaction_id"],
                    "to_address" => $address,
                    "amount" => $amount
                ]);
            } else {
                return ($this->isAppEnvironmentLocal()) ? dd($data) : false;
            }
        } else return false;
    }

    /**
     * Has Enough
     *
     * Compares the user balance to the $amount to see if they can make a transaction.
     *
     * @param float $amount
     * @return bool
     */
    public function hasEnough(float $amount): bool
    {
        return ($this->getBalance() >= $amount);
    }


    /**
     * Get Balance
     *
     * Get's the logged in user's balance
     * This utilizes the redis cache and stores data for a maximum for a single minute so the daemon isn't request flooded.
     *
     * @return float
     */
    public function getBalance()
    {
        if (Cache::tags('account-balance')->has(Auth::user()->username)) {
            return Cache::tags('account-balance')->get(Auth::user()->username);
        } else {
            $this->newRequest();
            $this->setMethod("getbalance");
            $this->setParameters([Auth::user()->username, 6]); // [username, minconf]
            $this->newCurlInstance();
            $data = $this->post();

            if ($data["status"] == "success") {
                return Cache::tags('account-balance')->remember(Auth::user()->username, 1, function () use ($data) {
                    return $data["result"];
                });
            } else return ($this->isAppEnvironmentLocal()) ? dd($data) : abort(500);
        }
    }

    public function getAddressBalance($address)
    {
        $this->newRequest();
        $this->setMethod("getbalance");
        $this->setParameters([Auth::user()->username, 6]); // [username, minconf]
        $this->newCurlInstance();
        $data = $this->post();

        if ($data["status"] == "success") {
            return Cache::tags('account-balance')->remember(Auth::user()->username, 1, function () use ($data) {
                return $data["result"];
            });
        } else return ($this->isAppEnvironmentLocal()) ? dd($data) : abort(500);
    }
}

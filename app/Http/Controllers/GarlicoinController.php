<?php

namespace App\Http\Controllers;

use App\Address;
use App\Transaction;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class GarlicoinController extends JsonRpcController
{
    public static $minconf = 12;

    /**
     * GarlicoinController constructor.
     */
    public function __construct()
    {
        $this->base_url = sprintf(
            "http://%s:%s@%s:%s/",
            config("app.rpc_username", "garlicoind"),
            config("app.rpc_password", "garlicoind"),
            config("app.rpc_host", "127.0.0.1"),
            config("app.rpc_port", 42070)
        );
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
        if (Address::getUserCount() < 100) {
            if (Cache::tags('new-address')->has(Auth::user()->username)) {
                session()->flash("error", "Creating a new address takes valuable disk space! - Please wait a few minutes before creating a new address.");
                return Cache::tags('new-address')->get(Auth::user()->username);
            } else {
                $this->newRequest();
                $this->setMethod("getnewaddress");
                $this->setParameters([Auth::user()->username]); // [username]
                $this->newCurlInstance();
                $data = $this->post();

                if ($data["error"] == null) {
                    return Cache::tags('new-address')->remember(Auth::user()->username, 5, function () use ($data) {
                        return Address::create([
                            "user_id" => Auth::user()->id,
                            "address" => $data["result"]
                        ]);
                    });
                } else {
                    return ($this->isAppEnvironmentLocal()) ? dd($data) : false;
                }
            }
        } else {
            session()->flash("error", "You have reached the maximum number of addresses for your account");
            return $this->getLastAddress();
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
    public function getListOfAddresses(): Collection
    {
        return Cache::tags('addresses')->remember(Auth::user()->username, 3, function () {
            return Address::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->get();
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
        // Trim the address
        $address = trim($address);

        // Placeholder
        $data = [];

        // Check if we have enough funds
        if ($this->hasEnough($amount)) {
            $this->newRequest();
            $this->setMethod("sendfrom");
            $this->setParameters([Auth::user()->username, $address, $amount, self::$minconf]); // [from_account, to_address, amount, minconf]
            $this->newCurlInstance();
            $data = $this->post();

            // If there's not an error, log the transaction.
            if ($data["error"] == null) {
                // Return the successful transaction
                return Transaction::create([
                    "user_id" => Auth::user()->id,
                    "transaction_id" => $data["result"],
                    "to_address" => $address,
                    "amount" => $amount
                ]);
            } else {
                // Ambiguous error
                session()->flash("error", $data["error"]["message"]);
                return false;
            }
        } else {
            // Insufficient funds
            session()->flash("error", "You do not have enough funds to make this transaction.");
            return false;
        }
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
        $this->newRequest();
        $this->setMethod("getbalance");
        $this->setParameters([Auth::user()->username, self::$minconf]); // [username, minconf]
        $this->newCurlInstance();
        $data = $this->post();
        if ($data["error"] == null) {
            return $data["result"];
        } else {
            abort(500);
        }
    }

    public function getServerBalance()
    {
        $this->newRequest();
        $this->setMethod("getbalance");
        $this->setParameters([]); // [username, minconf]
        $this->newCurlInstance();
        $data = $this->post();
        if ($data["error"] == null) {
            return $data["result"];
        } else {
            abort(500);
        }
    }

    public function getAddressBalance($address)
    {
        $this->newRequest();
        $this->setMethod("getbalance");
        $this->setParameters([Auth::user()->username, 6]); // [username, minconf]
        $this->newCurlInstance();
        $data = $this->post();

        if ($data["error"] == null) {
            return Cache::tags('account-balance')->remember(Auth::user()->username, 1, function () use ($data) {
                return $data["result"];
            });
        } else return ($this->isAppEnvironmentLocal()) ? dd($data) : abort(500);
    }
}

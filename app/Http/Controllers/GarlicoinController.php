<?php

namespace App\Http\Controllers;

use App\Address;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class GarlicoinController extends JsonRpcController
{
    public static $minconf = 3;
    private static $max_address_maturity = [
        "new" => 10,
        "old" => 100,
    ];

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
        // Check to see if their account is mature.
        if ($this->hasAccountMatured()) {
            // The account is mature
            if (Address::getUserCount() != self::$max_address_maturity["old"]) {
                // The user has less than the address hard limit, we can create one.
                return $this->getNewAddressInternal();
            } else {
                // The user has reached the hard limit.
                session()->flash("error", "You have reached the maximum number of addresses for your account");
                return $this->getLastAddress();
            }
        } else {
            // The account is not mature yet
            if (Address::getUserCount() != self::$max_address_maturity["new"]) {
                // The user has less than the address hard limit, we can create one.
                return $this->getNewAddressInternal();
            } else {
                // The user has reached the hard limit for their age.
                session()->flash("error", "Your account is still ralatively new, as a precaution your account is currently limited to a maximum of 10 addresses to prevent spam.");
                return $this->getLastAddress();
            }
        }
    }

    /**
     * Get New Address Internal
     *
     * The internal part of GetNewAddress so things aren't WET (Write everything twice)
     *
     * @return mixed
     */
    public function getNewAddressInternal()
    {
        $this->newRequest();
        $this->setMethod("getnewaddress");
        $this->setParameters([Auth::user()->username]); // [username]
        $this->newCurlInstance();
        $data = $this->post();

        if ($data["error"] == null) {
            // Clear the cache for all addresses
            Cache::tags("addresses")->forget(Auth::user()->username);

            // Return the data.
            return Address::create([
                "user_id" => Auth::user()->id,
                "address" => $data["result"]
            ]);
        } else {
            return ($this->isAppEnvironmentLocal()) ? dd($data) : false;
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
        return ($this->getBalance(true) >= $amount);
    }


    /**
     * Get Balance
     *
     * Get's the logged in user's balance
     * This utilizes the redis cache and stores data for a maximum for a single minute so the daemon isn't request flooded.
     *
     * @return float
     */
    public function getBalance($ignore_cache = false)
    {
        $this->newRequest();
        $this->setMethod("getbalance");
        $this->setParameters([Auth::user()->username, self::$minconf]); // [username, minconf]
        $this->newCurlInstance();

        if ($ignore_cache) {
            //Purge the old cache value.
            Cache::tags('balances')->forget(Auth::user()->username);

            // get the new data.
            $data = $this->post();

            if ($data["error"] == null) {
                return $data["result"];
            } else {
                abort(500);
            }
        } else {
            return Cache::tags('balances')->remember(Auth::user()->username, 3, function () {
                $data = $this->post();
                if ($data["error"] == null) {
                    return $data["result"];
                } else {
                    abort(500);
                }
            });
        }
    }

    /**
     * Get Server Balance
     *
     * Get's the current balance of the whole instance.
     *
     * @return mixed
     */
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

    /**
     * Get Address Balance
     *
     * Get's an addresses balance.
     *
     * @param $address
     */
    public function getAddressBalance($address)
    {
        $this->newRequest();
        $this->setMethod("getreceivedbyaddress");
        $this->setParameters([$address, self::$minconf]); // [address]
        $this->newCurlInstance();
        $data = $this->post();

        if ($data["error"] == null) {
            return $data["result"];
        } else return ($this->isAppEnvironmentLocal()) ? dd($data) : abort(500);
    }

    /**
     * Exxport Private Key
     *
     * Exports a private key to the relative passed address
     *
     * @param $address
     */
    public function exportPrivateKey($address)
    {
        $this->newRequest();
        $this->setMethod("dumpprivkey");
        $this->setParameters([$address]); // [address]
        $this->newCurlInstance();
        $data = $this->post();

        if ($data["error"] == null) {
            return $data["result"];
        } else return ($this->isAppEnvironmentLocal()) ? dd($data) : abort(500);
    }

    /**
     * Set Address Account
     *
     * Associates an address with an account
     *
     * @param $username
     * @param $address
     * @return bool|void
     */
    public function setAccount($username, $address)
    {
        $this->newRequest();
        $this->setMethod("setaccount");
        $this->setParameters([$address, $username]); // [address, username]
        $this->newCurlInstance();
        $data = $this->post();
        if ($data["error"] == null) {
            return true;
        } else return ($this->isAppEnvironmentLocal()) ? dd($data) : abort(500);
    }

    /**
     * Nullify Address Owner (deprecated)
     *
     * This function was originally created for the export function, but that caused issues
     * with negativve balances in the system.
     * This function is no longer used.
     *
     * @param $address
     * @return bool|void
     */
    public function nullifyAddressOwner($address)
    {
        $rand = bin2hex(openssl_random_pseudo_bytes(8));
        return $this->setAccount($rand, $address);
    }

    private function hasAccountMatured()
    {
        return (Carbon::now()->getTimestamp() - Carbon::parse(Auth::user()->created_at)->getTimestamp()) > 3600;
    }

    public function exchangeRate()
    {
        return Cache::tags('exchange')->remember('usd', 3, function () {
            return json_decode(file_get_contents("https://api.coinmarketcap.com/v1/ticker/garlicoin/"), true)[0]["price_usd"];
        });
    }
}

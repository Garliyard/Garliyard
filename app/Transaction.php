<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class Transaction extends Model
{
    protected $table = "transactions";

    protected $fillable = [
        "transaction_id", "user_id", "to_address", "amount"
    ];

    /**
     * Get the Transaction Model by specified ID (Cache)
     *
     * This uses the redis cache instead of making a database call.
     *
     * @param string $txid
     * @return Transaction
     */
    public static function getCachedByID(string $txid)
    {
        return Cache::tags('transaction')->remember($txid, 3600, function () use ($txid) {
            return self::where('transaction_id', $txid)->first();
        });

    }

    /**
     * Get Total Transaction Count
     *
     * @return mixed
     */
    public static function getCount()
    {
        return Cache::remember('total-transaction-count', 10, function () {
            return self::all()->count();
        });
    }

    public static function getRecentTransactionsFromUserID($user_id)
    {
        return Cache::tags('user-transactions')->remember(Auth::user()->username, 3, function () use ($user_id) {
            return self::where('user_id', $user_id)->orderBy('id', 'desc')->take(25)->get();
        });
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Transaction extends Model
{
    protected $table = "transactions";

    protected $fillable = [
        "transaction_id", "user_id"
    ];

    /**
     * Get the Transaction Model by specified ID (Cache)
     *
     * This uses the redis cache instead of making a database call.
     *
     * @param int $id
     * @return Transaction
     */
    public static function getCachedByID(int $id): self
    {
        Cache::tags('transaction')->remember($id, 3600, function () use ($id) {
            self::where('id', $id)->firstOrFail();
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
}

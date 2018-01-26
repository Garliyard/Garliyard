<?php

namespace App\Http\Controllers;

use App\Address;
use App\Http\Controllers\Auth\YubikeyController;
use App\Transaction;
use App\Yubikey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    private $garlicoind;

    public function __construct()
    {
        $this->middleware("auth");
        $this->garlicoind = new GarlicoinController();
    }

    public static function additionalAuthNeeded($redirect = true)
    {
        if (session()->has("yubikey-needed")) return ($redirect) ? redirect("/login/yubikey") : true;
        if (session()->has("totp-needed")) return ($redirect) ? redirect("/login/totp") : true;
        return false;
    }

    /**
     * Home View
     *
     * /home
     *
     * @return mixed
     */
    public function home()
    {
        if ($need = self::additionalAuthNeeded()) return $need;

        return view("dashboard/home")
            ->with('user', Auth::user())
            ->with('address', $this->garlicoind->getLastAddress())
            ->with('balance', $this->garlicoind->getBalance())
            ->with('transactions', Transaction::getRecentTransactionsFromUserID(Auth::user()->id));
    }

    /**
     * Addresses View
     *
     * The distinctive view that returns all the addresses for the user.
     *
     * @return $this
     */
    public function addresses()
    {
        if ($need = self::additionalAuthNeeded()) return $need;

        return view("dashboard/addresses")
            ->with('user', Auth::user())
            ->with('addresses', $this->garlicoind->getListOfAddresses());
    }

    /**
     * Transaction View
     *
     * The view that returns information about the transaction they made.
     *
     * @param $txid
     * @return $this
     */
    public function transactionView($txid)
    {
        if ($need = self::additionalAuthNeeded()) return $need;

        if ($transaction = Transaction::getCachedByID($txid)) {
            if ($transaction->user_id == Auth::user()->id) {
                return view("dashboard/transaction")
                    ->with("user", Auth::user())
                    ->with("transaction", $transaction);
            } else {
                return abort(404);
            }
        } else {
            return abort(404);
        }
    }

    /**
     * Generate New Address
     *
     * /new-address
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function newAddress()
    {
        if ($need = self::additionalAuthNeeded()) return $need;

        $this->garlicoind->getNewAddress();
        return redirect("/home");
    }

    /**
     * Pay view
     *
     * The user interface the user gets where they can put in an address to pay a user
     *
     * @return $this
     */
    public function payView()
    {
        if ($need = self::additionalAuthNeeded()) return $need;

        return view("dashboard/pay")
            ->with("balance", $this->garlicoind->getBalance(true));
    }

    /**
     * Pay Post Function
     *
     * The function that calls the garlicoin controller to pay the $adddress
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function pay(Request $request)
    {
        if ($need = self::additionalAuthNeeded()) return $need;

        if ($transaction = $this->garlicoind->pay($request->input("to_address"), $request->input("amount"))) {
            return redirect("transaction/" . $transaction->transaction_id);
        } else {
            return view("dashboard/pay")
                ->with("balance", $this->garlicoind->getBalance(true))
                ->with("to_address", $request->input("to_address"))
                ->with("amount", $request->input("amount"));
        }
    }

    /**
     * Transactions View
     *
     * List all the transactions on the distinctive page.
     *
     * @return mixed
     */
    public function transactions()
    {
        if ($need = self::additionalAuthNeeded()) return $need;

        return view("dashboard/transactions")
            ->with('user', Auth::user())
            ->with('transactions', Transaction::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->get())
            ->with('dont_truncate', true);
    }

    /**
     * Label Editor View
     *
     * The user interface that allow the user to enter a label
     *
     * @param $address
     * @return $this
     */
    public function labelEditorView($address)
    {
        if ($need = self::additionalAuthNeeded()) return $need;

        if ($address = Address::where('address', $address)->firstOrFail()) {
            if ($address->user_id == Auth::user()->id) {
                return view("dashboard/label_editor")
                    ->with("address", $address);
            } else {
                return abort(404);
            }
        }
    }

    /**
     * Post function for label editor
     *
     * When the user is done editing the label, this is the recieving function that interacts with the database.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function labelEditorPost(Request $request)
    {
        if ($need = self::additionalAuthNeeded()) return $need;

        if ($address = Address::where('address', $request->input("address"))->firstOrFail()) {
            if ($address->user_id == Auth::user()->id) {

                // Update the value in the database
                $address->update([
                    "label" => substr($request->input("label"), 0, 80)
                ]);

                // Purge the cache for the user.
                Cache::tags('addresses')->forget(Auth::user()->username);

                // Return the redirect to the view.
                return redirect("/addresses");
            } else {
                return abort(404);
            }
        }
    }

    public function accountTwoFactorIndex()
    {
        if ($need = self::additionalAuthNeeded()) return $need;

        return view("dashboard/account/2fa/index")
            ->with("yubikeys", Yubikey::getUserKeys());
    }



}

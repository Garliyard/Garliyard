<?php

namespace App\Http\Controllers;

use App\Address;
use App\Transaction;
use \Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    private $garlicoind;

    public function __construct()
    {
        $this->middleware("auth");
        $this->garlicoind = new GarlicoinController();
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
        return view("dashboard/home")
            ->with('user', Auth::user())
            ->with('address', $this->garlicoind->getLastAddress())
            ->with('balance', $this->garlicoind->getBalance())
            ->with('transactions', Transaction::getRecentTransactionsFromUserID(Auth::user()->id));
    }

    public function addresses()
    {
        return view("dashboard/addresses")
            ->with('user', Auth::user())
            ->with('addresses', $this->garlicoind->getListOfAddresses());
    }

    public function transactionView($txid)
    {
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
        $this->garlicoind->getNewAddress();
        return redirect("/home");
    }

    public function payView()
    {
        return view("dashboard/pay")
            ->with("balance", $this->garlicoind->getBalance());
    }

    public function pay(Request $request)
    {
        if ($transaction = $this->garlicoind->pay($request->input("to_address"), $request->input("amount"))) {
            return redirect("transaction/" . $transaction->transaction_id);
        } else {
            return view("dashboard/pay")
                ->with("balance", $this->garlicoind->getBalance())
                ->with("to_address", $request->input("to_address"))
                ->with("amount", $request->input("amount"));
        }
    }

    public function transactions()
    {

    }
}

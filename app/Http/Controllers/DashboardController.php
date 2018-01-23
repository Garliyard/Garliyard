<?php

namespace App\Http\Controllers;

use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    private $garlicoind;

    public function __construct()
    {
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

    public function payPost(Request $request)
    {
        $balance = $this->getBalance();
        $to_address = $request->input("address");
        $parsed_amount = floatval($request->input("amount"));

        // Check the user's balance
        if ($balance > $parsed_amount) {
            // The user has enough to make the transaction

            return redirect(sprintf("/transaction/%s", $this->garlicoind->pay($to_address, $parsed_amount)->id));
        } else {
            // The user does not have enough, tell them.

            // Perform basic math operation
            $math = ($balance - $parsed_amount);

            // Set an error and return it to the user.
            return view("/pay")
                ->with("address", $to_address)
                ->with("amount", $parsed_amount)
                ->with("error", sprintf("You do not have enough funds in your wallet. (-%f GRLC)", $math));
        }
    }

    public function transactionView($id)
    {
        $transaction = Transaction::getCachedByID($id);
        if ($transaction->user_id == Auth::user()->id) {
            return view("dashboard/transaction")
                ->with("user", Auth::user())
                ->with("transaction", $transaction);
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
            return redirect("transaction/" . $transaction->id);
        } else {
            return view("dashboard/pay")
                ->with("balance", $this->garlicoind->getBalance())
                ->with("to_address", $request->input("to_address"))
                ->with("amount", $request->input("amount"));
        }
    }
}

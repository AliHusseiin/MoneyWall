<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    //

    public function index($id){
        $transaction = Transaction::find($id);
        return view('transactions.index',compact('transaction'));
    }

    public function MoneyTransaction(Request $request) {
        $request->validate(Transaction::$rules);
        $transaction = new Transaction();
    }

    public function AssetTransaction(Request $request) {
        $request->validate(Transaction::$rules);
        $transaction = new Transaction();

    }

    public function BillTransaction(Request $request) {
        $request->validate(Transaction::$rules);
        $transaction = new Transaction();

    }
}

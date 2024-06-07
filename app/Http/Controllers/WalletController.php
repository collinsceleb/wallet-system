<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class WalletController extends Controller
{
    public function index()
    {
        $wallet = Auth::user()->wallet;
        if (!$wallet) {
            $wallet = new Wallet(['balance' => 0]);
            $wallet->user_id = Auth::id();
            $wallet->save();
        }
        return inertia('Wallet', ['wallet' => $wallet]);
    }

    public function showCreditForm()
    {
        $user = auth()->user();
        return Inertia::render('CreditWallet', ['userId' => $user->id]);
    }

    public function showDebitForm()
    {
        $user = auth()->user();
        return Inertia::render('DebitWallet', ['userId' => $user->id]);
    }

    public function credit(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
        ]);

        DB::transaction(function () use ($request) {
            $wallet = Wallet::where('user_id', Auth::id())->lockForUpdate()->first();

            if ($wallet) {
                $wallet->balance += $request->amount;
                $wallet->save();
            } else {
                // Create a new wallet record if it doesn't exist
                $wallet = new Wallet();
                $wallet->user_id = Auth::id();
                $wallet->balance = $request->amount;
                $wallet->save();
            }
            // $wallet->balance += $request->amount;
            // $wallet->save();
        });

        return redirect()->route('wallet.index');
    }

    public function debit(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
        ]);

        DB::transaction(function () use ($request) {
            $wallet = Wallet::where('user_id', Auth::id())->lockForUpdate()->first();

            if ($wallet->balance >= $request->amount) {
                $wallet->balance -= $request->amount;
                $wallet->save();
            } else {
                throw new \Exception('Insufficient funds');
            }
        });

        return redirect()->route('wallet.index');
    }
}

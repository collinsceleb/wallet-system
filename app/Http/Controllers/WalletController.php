<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{
    public function credit(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
        ]);

        $wallet = Auth::user()->wallet;

        if ($wallet->creditWithRetry($request->amount)) {
            return response()->json(['balance' => $wallet->balance], 200);
        } else {
            return response()->json(['error' => 'Transaction failed after multiple attempts'], 500);
        }
    }

    public function debit(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
        ]);

        $wallet = Auth::user()->wallet;

        if ($wallet->debitWithRetry($request->amount)) {
            return response()->json(['balance' => $wallet->balance], 200);
        } else {
            return response()->json(['error' => 'Transaction failed after multiple attempts'], 500);
        }
    }
}

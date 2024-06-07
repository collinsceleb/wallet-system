<?php

namespace App\Http\Controllers;

use App\Exports\TransactionsExport;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use League\Csv\Writer;
use Illuminate\Support\Facades\Response;

class AdminController extends Controller
{
    public function dashboard()
    {
        $users = User::with('wallet')->get();
        // dd($users);
        return inertia('Admin/Dashboard', ['users' => $users]);
    }

    public function credit(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0.01',
        ]);

        DB::transaction(function () use ($request) {
            $wallet = Wallet::where('user_id', $request->user_id)->lockForUpdate()->first();
            $wallet->balance += $request->amount;
            $wallet->save();
        });

        return redirect()->route('admin.dashboard');
    }

    public function debit(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0.01',
        ]);

        DB::transaction(function () use ($request) {
            $wallet = Wallet::where('user_id', $request->user_id)->lockForUpdate()->first();

            if ($wallet->balance >= $request->amount) {
                $wallet->balance -= $request->amount;
                $wallet->save();
            } else {
                throw new \Exception('Insufficient funds');
            }
        });

        return redirect()->route('admin.dashboard');
    }

    public function reports()
    {
        $transactions = DB::table('transactions')
        ->select(DB::raw('date(created_at) as date'), DB::raw('sum(amount) as total'))
        ->groupBy('date')
        ->get();

        return inertia('Admin/Reports', ['transactions' => $transactions]);
    }

    public function exportPDF()
    {
        $transactions = Transaction::all();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('reports.transactions', compact('transactions'));

        return $pdf->download('weekly_transactions_report.pdf');
    }

    public function exportCSV()
    {
        $transactions = Transaction::all();

        $csv = Writer::createFromString('');

        $csv->insertOne(['ID', 'User ID', 'Type', 'Amount', 'Created At', 'Updated At']);

        foreach ($transactions as $transaction) {
            $csv->insertOne([
                $transaction->id,
                $transaction->user_id,
                $transaction->type,
                $transaction->amount,
                $transaction->created_at,
                $transaction->updated_at,
            ]);
        }

        return Response::make($csv->toString(), 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="transactions.csv"',
        ]);
    }
}

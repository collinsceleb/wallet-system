<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'balance'];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function credit($amount)
    {
        DB::transaction(function () use ($amount) {
            $wallet = $this->lockForUpdate()->find($this->id);
            $wallet->balance += $amount;
            $wallet->save();

            $wallet->transactions()->create([
                'amount' => $amount,
                'type' => 'credit'
            ]);
        });
    }

    public function debit($amount)
    {
        DB::transaction(function () use ($amount) {
            $wallet = $this->lockForUpdate()->find($this->id);
            if ($wallet->balance < $amount) {
                throw new \Exception('Insufficient funds');
            }

            $wallet->balance -= $amount;
            $wallet->save();

            $wallet->transactions()->create([
                'amount' => $amount,
                'type' => 'debit'
            ]);
        });
    }

    public function creditWithRetry($amount)
    {
        $maxAttempts = 3;
        $attempt = 0;

        while ($attempt < $maxAttempts) {
            try {
                $this->credit($amount);
                return true;  // Success
            } catch (\Exception $e) {
                $attempt++;
                if ($attempt >= $maxAttempts) {
                    Log::error('Credit transaction failed after multiple attempts: ' . $e->getMessage());
                    return false;  // Failure after retries
                }
                sleep(1);  // Optional delay before retrying
            }
        }
    }

    public function debitWithRetry($amount)
    {
        $maxAttempts = 3;
        $attempt = 0;

        while ($attempt < $maxAttempts) {
            try {
                $this->debit($amount);
                return true;  // Success
            } catch (\Exception $e) {
                $attempt++;
                if ($attempt >= $maxAttempts) {
                    Log::error('Debit transaction failed after multiple attempts: ' . $e->getMessage());
                    return false;  // Failure after retries
                }
                sleep(1);  // Optional delay before retrying
            }
        }
    }
}

<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WalletController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth'])->group(function () {
    Route::get('wallet', function () {
        $user = App\Models\User::find(Auth::id());
        $user->load('wallet');
        return Inertia::render('Wallet', [
            'user' => $user
        ]);
    })->name('wallet.index');
    Route::post('/wallet/credit', [WalletController::class, 'credit'])->name('wallet.credit');
    Route::get('/wallet/credit', [WalletController::class, 'showCreditForm'])->name('wallet.credit.form');
    Route::post('/wallet/debit', [WalletController::class, 'debit'])->name('wallet.debit');
    Route::get('/wallet/debit', [WalletController::class, 'showDebitForm'])->name('wallet.debit.form');
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/admin/credit', [AdminController::class, 'credit'])->name('admin.credit');
    Route::post('/admin/debit', [AdminController::class, 'debit'])->name('admin.debit');
    Route::get('/admin/reports', [AdminController::class, 'reports'])->name('admin.reports');
    Route::get('/admin/exportPDF', [AdminController::class, 'exportPDF'])->name('admin.exportPDF');
    Route::get('/admin/exportCSV', [AdminController::class, 'exportCSV'])->name('admin.exportCSV');
    Route::get('/user/show', [UserController::class, 'show'])->name('user.show');

});

// Route::middleware(['admin'])->group(function () {
//     Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
//     Route::post('/admin/credit', [AdminController::class, 'credit'])->name('admin.credit');
//     Route::post('/admin/debit', [AdminController::class, 'debit'])->name('admin.debit');
//     Route::get('/admin/reports', [AdminController::class, 'reports'])->name('admin.reports');
//     Route::get('/admin/export', [AdminController::class, 'exportPDF'])->name('admin.exportPDF');
//     Route::get('/admin/export', [AdminController::class, 'exportCSV'])->name('admin.exportCSV');

// });


require __DIR__.'/auth.php';

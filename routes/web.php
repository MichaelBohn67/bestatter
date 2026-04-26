<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DeceasedController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RelativeController;
use App\Http\Controllers\FuneralServiceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/locale/{locale}', function (string $locale) {
    if (! in_array($locale, ['en', 'de'], true)) {
        abort(404);
    }

    session(['locale' => $locale]);

    return redirect()->back();
})->name('locale.switch');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/admin', function () {
        return view('admin');
    })->name('admin');

    Route::resource('funeral-services', FuneralServiceController::class);
    Route::resource('deceased', DeceasedController::class)->only(['index', 'create', 'store']);
    Route::resource('relatives', RelativeController::class)->only(['index', 'create', 'store']);
    Route::resource('customers', CustomerController::class)->only(['index', 'create', 'store', 'edit', 'update']);
    Route::resource('billings', BillingController::class)->only(['index', 'create', 'store', 'edit', 'update']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

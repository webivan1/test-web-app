<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Auth::routes([
    'register' => false,
    'verify' => false,
    'reset' => false,
    'confirm' => false
]);

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::resource('client', \App\Http\Controllers\ClientController::class)
        ->except(['show']);

    Route::group([
        'prefix' => 'client/{client}',
        'as' => 'client.'
    ], function () {
        Route::resource('transaction', \App\Http\Controllers\TransactionController::class)
            ->except(['show']);
    });
});

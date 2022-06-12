<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MovementController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\EmailController;
use App\Http\Controllers\User\PhoneController;
use App\Http\Controllers\User\RetireController;
use App\Http\Controllers\User\DepositController;
use App\Http\Controllers\Transfer\TransferBasicController;
use App\Http\Controllers\Transfer\TransferMultiController;


Route::prefix('user')
    ->group(function () {
        Route::prefix('home')
            ->group(function () {
                Route::get('index', [HomeController::class, 'index'])->name('user.home.index');
            });
        Route::prefix('profiles')
            ->middleware('can:user.profiles.index')
            ->group(function () {
                Route::resource('index', UserController::class)->names('user.profiles');
            });
        Route::prefix('phones')
            ->middleware('can:user.phones.index')
            ->group(function () {
                Route::resource('index', PhoneController::class)->names('user.phones')->only('edit', 'create');
            });
        Route::prefix('emails')
            ->middleware('can:user.emails.index')
            ->group(function () {
                Route::resource('index', EmailController::class)->names('user.emails');
            });
        Route::prefix('envioMultis')
            ->middleware('can:user.envioMulti.index')
            ->group(function () {
                Route::resource('index', TransferMultiController::class)->names('user.envioMulti');
            });
        Route::prefix('ingress')
            // ->middleware('can:user.ingress.index')
            ->group(function () {
                Route::resource('index', DepositController::class)->names('user.ingress')->only('index', 'store');
            });
        Route::prefix('retire')
            // ->middleware('can:user.retire.index')
            ->group(function () {
                Route::resource('index', RetireController::class)->names('user.retire');
            });
        Route::prefix('envioBasicos')
            ->middleware('can:user.envioBasicos.index')
            ->group(function () {
                Route::resource('index', TransferBasicController::class)->names('user.envioBasicos');
            });
        Route::prefix('movements')
            // ->middleware('user.movements.index')
            ->group(function () {
                Route::get('getMovementDatatable', [MovementController::class, 'getMovementDatatable'])->name('user.movements.getMovementDatatable');
                Route::resource('index', MovementController::class)->names('user.movements');
            });
    });

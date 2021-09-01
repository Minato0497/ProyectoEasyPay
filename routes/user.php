<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\EmailController;
use App\Http\Controllers\User\PhoneController;
use App\Http\Controllers\User\AddressController;
use App\Http\Controllers\User\CreditCardController;
use App\Http\Controllers\RecordMoneyTransferController;


Route::get('trasnfer-register', [RecordMoneyTransferController::class, 'index'])->name('trasnfer-register.index');
Route::get('trasnfer-register/{user}', [RecordMoneyTransferController::class, 'show'])->name('trasnfer-register.show');

Route::resource('user/profile', UserController::class)->names('profile');
Route::resource('user/profile/phone', PhoneController::class)->names('phone');
Route::resource('user/profile/email', EmailController::class)->names('email');
Route::resource('user/profile/address', AddressController::class)->names('address');
Route::resource('user/profile/creditCard', CreditCardController::class)->names('creditCard');

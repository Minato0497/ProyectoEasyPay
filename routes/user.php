<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\EmailController;
use App\Http\Controllers\User\PhoneController;
use App\Http\Controllers\User\AddressController;
use App\Http\Controllers\User\CreditCardController;
use App\Http\Controllers\RecordMoneyTransferController;


Route::get('trasnfer-register', [RecordMoneyTransferController::class,'index'])->name('trasnfer-register.index');
Route::get('trasnfer-register/{user}', [RecordMoneyTransferController::class,'show'])->name('trasnfer-register.show');

Route::resource('user/profile', UserController::class);
Route::resource('user/profile/phone', PhoneController::class);
Route::resource('user/profile/email', EmailController::class);
Route::resource('user/profile/address', AddressController::class);
Route::resource('user/profile/creditCard', CreditCardController::class);


<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\EmailController;
use App\Http\Controllers\User\PhoneController;
use App\Http\Controllers\User\AddressController;
use App\Http\Controllers\User\CreditCardController;
use App\Http\Controllers\RecordMoneyTransferController;


Route::resource('trasnfer-register', RecordMoneyTransferController::class)->only('index', 'show')->names('trasnfer-register');
Route::resource('user/profile', UserController::class)->names('profile');
Route::resource('user/profile/phone', PhoneController::class)->names('phone');
Route::resource('user/profile/email', EmailController::class)->names('email');
Route::resource('user/profile/address', AddressController::class)->names('address');
Route::resource('user/profile/creditCard', CreditCardController::class)->names('creditCard');

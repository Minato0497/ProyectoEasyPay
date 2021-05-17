<?php

use App\Http\Controllers\Transfer\CreditCardTransferController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Transfer\TransferBasicController;

Route::resource('envios/envioBasico', TransferBasicController::class)->names('envioBasico');
Route::resource('user/transfer/creditCard', CreditCardTransferController::class)->names('transfercreditcard');

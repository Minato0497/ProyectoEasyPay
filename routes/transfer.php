<?php

use App\Http\Controllers\Transfer\CreditCardTransferController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Transfer\TransferBasicController;
use App\Http\Controllers\Transfer\TransferMultiController;

Route::resource('envios/envioBasico', TransferBasicController::class)->names('envioBasico');
Route::resource('envios/envosMultiple', TransferMultiController::class)->names('envioMulti');
Route::resource('user/transfer/creditCard', CreditCardTransferController::class)->names('transfercreditcard');

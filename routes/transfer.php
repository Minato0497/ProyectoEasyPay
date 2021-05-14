<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Transfer\TransferBasicController;

Route::resource('envios/envio_basico', TransferBasicController::class)->names('envio_basico');

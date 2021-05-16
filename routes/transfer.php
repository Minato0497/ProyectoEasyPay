<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Transfer\TransferBasicController;

Route::resource('envios/envioBasico', TransferBasicController::class)->names('envioBasico');

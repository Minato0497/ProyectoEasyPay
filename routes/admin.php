<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserRoleController;

Route::resource('admin/roleUser', UserRoleController::class);
Route::resource('admin', AdminController::class);

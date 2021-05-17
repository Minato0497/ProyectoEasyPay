<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserRoleController;

Route::resource('admin/role/user', UserRoleController::class)->only('index', 'edit', 'update')->names('roleUser');
Route::resource('admin', AdminController::class);

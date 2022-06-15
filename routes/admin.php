<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\IngressController;
use App\Http\Controllers\OperationTypeController;
use App\Http\Controllers\Admin\UserRoleController;
use App\Http\Controllers\Admin\MovementsController;

Auth::routes();

Route::prefix('admin')
    // ->middleware('admin.admin.index')
    ->group(function () {
        Route::prefix('admin')
            ->middleware('can:admin.admin.index')
            ->group(function () {
                Route::resource('index', AdminController::class)->only('index')->names('admin.admin');
            });
        Route::prefix('roleUser')
            ->middleware('can:admin.roleUsers.index')
            ->group(function () {
                Route::get('getUserDatatable', [UserRoleController::class, 'getUserDatatable'])->name('admin.roleUsers.getUserDatatable');
                Route::resource('index', UserRoleController::class)->only('index', 'edit', 'update', 'store')->names('admin.roleUsers');
            });
        Route::prefix('ingress')
            ->middleware('can:admin.ingress.index')
            ->group(function () {
                Route::post('ingress/{id}', [IngressController::class, 'ingreso'])->name('admin.ingress.ingreso');
                Route::get('getMovementDatatable', [IngressController::class, 'getMovementDatatable'])->name('admin.ingress.getMovementDatatable');
                Route::resource('index', IngressController::class)->only('index')->names('admin.ingress');
            });
        Route::prefix('movements')
            ->middleware('can:admin.movements.index')
            ->group(function () {
                Route::get('getMovementDatatable', [MovementsController::class, 'getMovementDatatable'])->name('admin.movements.getMovementDatatable');
                Route::resource('index', MovementsController::class)->names('admin.movements');
            });
        Route::prefix('operationTypes')
            ->middleware('can:admin.operationTypes.index')
            ->group(function () {
                Route::get('getOperationTypeDatatable', [OperationTypeController::class, 'getOperationTypeDatatable'])->name('admin.operationTypes.getOperationTypeDatatable');
                Route::resource('index', OperationTypeController::class)->names('admin.operationTypes');
            });
    });

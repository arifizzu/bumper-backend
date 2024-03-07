<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\FormTemplateController;
use App\Http\Controllers\FieldTypeController;
use App\Http\Controllers\FieldController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/users')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::get('/create', [UserController::class, 'create']);
        Route::post('/', [UserController::class, 'store']);
        Route::get('/{id}', [UserController::class, 'show']);
        Route::get('/{id}/edit', [UserController::class, 'edit']);
        Route::put('/{id}', [UserController::class, 'update']);
        Route::delete('/{id}', [UserController::class, 'destroy']);
    });


Route::prefix('/roles')->group(function () {
        Route::get('/', [RoleController::class, 'index']);
        Route::get('/create', [RoleController::class, 'create']);
        Route::post('/', [RoleController::class, 'store']);
        Route::get('/{id}', [RoleController::class, 'show']);
        Route::get('/{id}/edit', [RoleController::class, 'edit']);
        Route::put('/{id}', [RoleController::class, 'update']);
        Route::delete('/{id}', [RoleController::class, 'destroy']);
    });

Route::prefix('/permissions')->group(function () {
    Route::get('/', [PermissionController::class, 'index']);
    Route::get('/create', [PermissionController::class, 'create']);
    Route::post('/', [PermissionController::class, 'store']);
    Route::get('/{id}', [PermissionController::class, 'show']);
    Route::get('/{id}/edit', [PermissionController::class, 'edit']);
    Route::put('/{id}', [PermissionController::class, 'update']);
    Route::delete('/{id}', [PermissionController::class, 'destroy']);
    });

Route::prefix('/forms')->group(function () {
    Route::get('/', [FormController::class, 'index']);
    Route::get('/create', [FormController::class, 'create']);
    Route::post('/', [FormController::class, 'store']);
    Route::get('/{id}', [FormController::class, 'show']);
    Route::get('/{id}/edit', [FormController::class, 'edit']);
    Route::put('/{id}', [FormController::class, 'update']);
    Route::delete('/{id}', [FormController::class, 'destroy']);
    });

Route::prefix('/forms-template')->group(function () {
    Route::get('/', [FormTemplateController::class, 'showAllTemplateForm']);    //index
    Route::post('/', [FormTemplateController::class, 'saveFormAsTemplate']);    //store
    Route::delete('/{id}', [FormTemplateController::class, 'deleteTemplateForm']);      //destroy
    });

Route::prefix('/fields-types')->group(function () {
    Route::get('/', [FieldTypeController::class, 'showAllFieldTypes']);    //index
    });

Route::prefix('/fields')->group(function () {
    Route::get('/{id}', [FieldController::class, 'index']);
    Route::get('/{id}/create', [FieldController::class, 'create']);
    Route::post('/', [FieldController::class, 'store']);
    Route::get('/individual/{id}', [FieldController::class, 'show']);
    Route::get('/individual/{id}/edit', [FieldController::class, 'edit']);
    Route::put('/individual/{id}', [FieldController::class, 'update']);
    Route::delete('/individual/{id}', [FieldController::class, 'destroy']);
    });

// Route::prefix('/roles')->group(function () {
//     Route::get('/', [RoleController::class, 'index'])->middleware(['permissions:view role']);
//     Route::get('/create', [RoleController::class, 'create'])->middleware(['permissions:create role']);
//     Route::post('/', [RoleController::class, 'store'])->middleware(['permissions:create role']);
//     Route::get('/{id}', [RoleController::class, 'show'])->middleware(['permissions:view role']);
//     Route::get('/{id}/edit', [RoleController::class, 'edit'])->middleware(['permissions:update role']);
//     Route::put('/{id}', [RoleController::class, 'update'])->middleware(['permissions:update role']);
//     Route::delete('/{id}', [RoleController::class, 'destroy'])->middleware(['permissions:delete role']);
// });
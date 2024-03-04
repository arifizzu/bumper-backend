<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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


// Route::prefix('/roles')->group(function () {
//         Route::get('/', [RoleController::class, 'index'])->middleware(['permissions:view role']);
//         Route::get('/create', [RoleController::class, 'create'])->middleware(['permissions:create role']);
//         Route::post('/', [RoleController::class, 'store'])->middleware(['permissions:create role']);
//         Route::get('/{id}', [RoleController::class, 'show'])->middleware(['permissions:view role']);
//         Route::get('/{id}/edit', [RoleController::class, 'edit'])->middleware(['permissions:update role']);
//         Route::put('/{id}', [RoleController::class, 'update'])->middleware(['permissions:update role']);
//         Route::delete('/{id}', [RoleController::class, 'destroy'])->middleware(['permissions:delete role']);
//     });
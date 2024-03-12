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
use App\Http\Controllers\FieldListValueController;
use App\Http\Controllers\ProcessController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ActivityRelationController;
use App\Http\Controllers\AuthController;

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

Route::prefix('/auth')->group(function () {
    Route::get('/signup', [AuthController::class, 'signUp']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/me', [AuthController::class, 'me']);
    });

Route::prefix('/users')->middleware(['auth:api'])->group(function () {
        Route::get('/', [UserController::class, 'index'])->middleware(['permission:view user']);
        Route::get('/create', [UserController::class, 'create'])->middleware(['permission:create user']);
        Route::post('/', [UserController::class, 'store'])->middleware(['permission:create user']);
        Route::get('/{id}', [UserController::class, 'show'])->middleware(['permission:view user']);
        Route::get('/{id}/edit', [UserController::class, 'edit'])->middleware(['permission:update user']);
        Route::put('/{id}', [UserController::class, 'update'])->middleware(['permission:update user']);
        Route::delete('/{id}', [UserController::class, 'destroy'])->middleware(['permission:delete user']);
    });


Route::prefix('/roles')->middleware(['auth:api'])->group(function () {
        Route::get('/', [RoleController::class, 'index'])->middleware(['permission:view role']);
        Route::get('/create', [RoleController::class, 'create'])->middleware(['permission:create role']);
        Route::post('/', [RoleController::class, 'store'])->middleware(['permission:create role']);
        Route::get('/{id}', [RoleController::class, 'show'])->middleware(['permission:view role']);
        Route::get('/{id}/edit', [RoleController::class, 'edit'])->middleware(['permission:update role']);
        Route::put('/{id}', [RoleController::class, 'update'])->middleware(['permission:update role']);
        Route::delete('/{id}', [RoleController::class, 'destroy'])->middleware(['permission:delete role']);
    });

Route::prefix('/permissions')->middleware(['auth:api'])->group(function () {
    Route::get('/', [PermissionController::class, 'index'])->middleware(['permission:view permission']);
    Route::get('/create', [PermissionController::class, 'create'])->middleware(['permission:create permission']);
    Route::post('/', [PermissionController::class, 'store'])->middleware(['permission:create permission']);
    Route::get('/{id}', [PermissionController::class, 'show'])->middleware(['permission:view permission']);
    Route::get('/{id}/edit', [PermissionController::class, 'edit'])->middleware(['permission:update permission']);
    Route::put('/{id}', [PermissionController::class, 'update'])->middleware(['permission:update permission']);
    Route::delete('/{id}', [PermissionController::class, 'destroy'])->middleware(['permission:delete permission']);
    });

Route::prefix('/forms')->middleware(['auth:api'])->group(function () {
    Route::get('/', [FormController::class, 'index'])->middleware(['permission:view form']);
    Route::get('/create', [FormController::class, 'create'])->middleware(['permission:create form']);
    Route::post('/', [FormController::class, 'store'])->middleware(['permission:create form']);
    Route::get('/{id}', [FormController::class, 'show'])->middleware(['permission:view form']);
    Route::get('/{id}/edit', [FormController::class, 'edit'])->middleware(['permission:update form']);
    Route::put('/{id}', [FormController::class, 'update'])->middleware(['permission:update form']);
    Route::delete('/{id}', [FormController::class, 'destroy'])->middleware(['permission:delete form']);
    });

Route::prefix('/forms-template')->middleware(['auth:api'])->group(function () {
    Route::get('/', [FormTemplateController::class, 'showAllTemplateForm'])->middleware(['permission:view form|create form|update form']);;    //index
    Route::post('/', [FormTemplateController::class, 'saveFormAsTemplate'])->middleware(['permission:view form|create form|update form']);    //store
    Route::delete('/{id}', [FormTemplateController::class, 'deleteTemplateForm'])->middleware(['permission:view form|create form|update form|delete form']);       //destroy
    });

Route::prefix('/fields-types')->middleware(['auth:api'])->group(function () {
    Route::get('/', [FieldTypeController::class, 'showAllFieldTypes'])->middleware(['permission:view form|create form|update form']);   //index
    });

Route::prefix('/fields')->middleware(['auth:api'])->group(function () {
    Route::get('/{id}', [FieldController::class, 'index'])->middleware(['permission:view form']);
    Route::get('/{id}/create', [FieldController::class, 'create'])->middleware(['permission:create form']);
    Route::post('/', [FieldController::class, 'store'])->middleware(['permission:create form']);
    Route::get('/individual/{id}', [FieldController::class, 'show'])->middleware(['permission:view form']);
    Route::get('/individual/{id}/edit', [FieldController::class, 'edit'])->middleware(['permission:update form']);
    Route::put('/individual/{id}', [FieldController::class, 'update'])->middleware(['permission:update form']);
    Route::delete('/individual/{id}', [FieldController::class, 'destroy'])->middleware(['permission:delete form']);
    });

Route::prefix('/fields-values')->middleware(['auth:api'])->group(function () {
    Route::get('/{id}', [FieldListValueController::class, 'index'])->middleware(['permission:view form']);
    Route::get('/{id}/create', [FieldListValueController::class, 'create'])->middleware(['permission:create form']);
    Route::post('/{id}', [FieldListValueController::class, 'store'])->middleware(['permission:create form']);
    Route::get('/individual/{id}', [FieldListValueController::class, 'show'])->middleware(['permission:view form']);
    Route::get('/individual/{id}/edit', [FieldListValueController::class, 'edit'])->middleware(['permission:update form']);
    Route::put('/individual/{id}', [FieldListValueController::class, 'update'])->middleware(['permission:update form']);
    Route::delete('/individual/{id}', [FieldListValueController::class, 'destroy'])->middleware(['permission:delete form']);
    });

Route::prefix('/processes')->middleware(['auth:api'])->group(function () {
    Route::get('/', [ProcessController::class, 'index'])->middleware(['permission:view process']);
    Route::get('/create', [ProcessController::class, 'create'])->middleware(['permission:create process']);
    Route::post('/', [ProcessController::class, 'store'])->middleware(['permission:create process']);
    Route::get('/{id}', [ProcessController::class, 'show'])->middleware(['permission:view process']);
    Route::get('/{id}/edit', [ProcessController::class, 'edit'])->middleware(['permission:update process']);
    Route::put('/{id}', [ProcessController::class, 'update'])->middleware(['permission:update process']);
    Route::delete('/{id}', [ProcessController::class, 'destroy'])->middleware(['permission:delete process']);
    });

Route::prefix('/activities')->middleware(['auth:api'])->group(function () {
    Route::get('/', [ActivityController::class, 'index'])->middleware(['permission:view process']);
    Route::get('/create', [ActivityController::class, 'create'])->middleware(['permission:create process']);
    Route::post('/', [ActivityController::class, 'store'])->middleware(['permission:create process']);
    Route::get('/{id}', [ActivityController::class, 'show'])->middleware(['permission:view process']);
    Route::get('/{id}/edit', [ActivityController::class, 'edit'])->middleware(['permission:update process']);
    Route::put('/{id}', [ActivityController::class, 'update'])->middleware(['permission:update process']);
    Route::delete('/{id}', [ActivityController::class, 'destroy'])->middleware(['permission:delete process']);
    });

Route::prefix('/activities-relations')->middleware(['auth:api'])->group(function () {
    Route::get('/', [ActivityRelationController::class, 'index'])->middleware(['permission:view process']);
    Route::get('/create', [ActivityRelationController::class, 'create'])->middleware(['permission:create process']);
    Route::post('/', [ActivityRelationController::class, 'store'])->middleware(['permission:create process']);
    Route::get('/{id}', [ActivityRelationController::class, 'show'])->middleware(['permission:view process']);
    Route::get('/{id}/edit', [ActivityRelationController::class, 'edit'])->middleware(['permission:update process']);
    Route::put('/{id}', [ActivityRelationController::class, 'update'])->middleware(['permission:update process']);
    Route::delete('/{id}', [ActivityRelationController::class, 'destroy'])->middleware(['permission:delete process']);
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
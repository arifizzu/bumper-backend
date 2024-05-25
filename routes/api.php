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
use App\Http\Controllers\DatabaseRetrievalController;
use App\Http\Controllers\ConditionController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\FieldLocationController;
use App\Http\Controllers\ActivityLocationController;
use App\Http\Controllers\DataListController;
use App\Http\Controllers\DataListItemController;
use App\Http\Controllers\DataListFilterController;
use App\Http\Controllers\DataListActionController;

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

Route::prefix('/database')->middleware(['auth:api'])->group(function () {
    Route::get('/tables', [DatabaseRetrievalController::class, 'getTables'])->middleware(['permission:create form']);
    Route::get('/columns', [DatabaseRetrievalController::class, 'getColumns'])->middleware(['permission:create form']);
    Route::get('/latestId', [DatabaseRetrievalController::class, 'getLatestId'])->middleware(['permission:create form']);
    });

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
        Route::get('/{id}/edit', [UserController::class, 'edit'])->middleware(['permission:edit user']);
        Route::put('/{id}', [UserController::class, 'update'])->middleware(['permission:edit user']);
        Route::delete('/{id}', [UserController::class, 'destroy'])->middleware(['permission:delete user']);
    });


Route::prefix('/roles')->middleware(['auth:api'])->group(function () {
        Route::get('/', [RoleController::class, 'index'])->middleware(['permission:view role']);
        Route::get('/create', [RoleController::class, 'create'])->middleware(['permission:create role']);
        Route::post('/', [RoleController::class, 'store'])->middleware(['permission:create role']);
        Route::get('/{id}', [RoleController::class, 'show'])->middleware(['permission:view role']);
        Route::get('/{id}/edit', [RoleController::class, 'edit'])->middleware(['permission:edit role']);
        Route::put('/{id}', [RoleController::class, 'update'])->middleware(['permission:edit role']);
        Route::delete('/{id}', [RoleController::class, 'destroy'])->middleware(['permission:delete role']);
    });

Route::prefix('/permissions')->middleware(['auth:api'])->group(function () {
    Route::get('/', [PermissionController::class, 'index'])->middleware(['permission:view permission']);
    Route::get('/create', [PermissionController::class, 'create'])->middleware(['permission:create permission']);
    Route::post('/', [PermissionController::class, 'store'])->middleware(['permission:create permission']);
    Route::get('/{id}', [PermissionController::class, 'show'])->middleware(['permission:view permission']);
    Route::get('/{id}/edit', [PermissionController::class, 'edit'])->middleware(['permission:edit permission']);
    Route::put('/{id}', [PermissionController::class, 'update'])->middleware(['permission:edit permission']);
    Route::delete('/{id}', [PermissionController::class, 'destroy'])->middleware(['permission:delete permission']);
    });

Route::prefix('/groups')->middleware(['auth:api'])->group(function () {
    Route::get('/', [GroupController::class, 'index'])->middleware(['permission:view form']);
    Route::get('/create', [GroupController::class, 'create'])->middleware(['permission:create form']);
    Route::post('/', [GroupController::class, 'store'])->middleware(['permission:create form']);
    Route::get('/{id}', [GroupController::class, 'show'])->middleware(['permission:view form']);
    Route::get('/{id}/edit', [GroupController::class, 'edit'])->middleware(['permission:edit form']);
    Route::put('/{id}', [GroupController::class, 'update'])->middleware(['permission:edit form']);
    Route::delete('/{id}', [GroupController::class, 'destroy'])->middleware(['permission:delete form']);
    });

Route::prefix('/forms')->middleware(['auth:api'])->group(function () {
    Route::get('/', [FormController::class, 'index'])->middleware(['permission:view form']);
    Route::get('/create', [FormController::class, 'create'])->middleware(['permission:create form']);
    Route::post('/', [FormController::class, 'store'])->middleware(['permission:create form']);
    Route::get('/{id}', [FormController::class, 'show'])->middleware(['permission:view form']);
    Route::get('/{id}/edit', [FormController::class, 'edit'])->middleware(['permission:edit form']);
    Route::put('/{id}', [FormController::class, 'update'])->middleware(['permission:edit form']);
    Route::delete('/{id}', [FormController::class, 'destroy'])->middleware(['permission:delete form']);
    });

Route::prefix('/forms-template')->middleware(['auth:api'])->group(function () {
    Route::get('/', [FormTemplateController::class, 'showAllTemplateForm'])->middleware(['permission:view form|create form|edit form']);;    //index
    Route::post('/', [FormTemplateController::class, 'saveFormAsTemplate'])->middleware(['permission:view form|create form|edit form']);    //store
    Route::delete('/{id}', [FormTemplateController::class, 'deleteTemplateForm'])->middleware(['permission:view form|create form|edit form|delete form']);       //destroy
    });

Route::prefix('/fields-types')->middleware(['auth:api'])->group(function () {
    Route::get('/', [FieldTypeController::class, 'showAllFieldTypes'])->middleware(['permission:view form|create form|edit form']);   //index
    });

Route::prefix('/fields')->middleware(['auth:api'])->group(function () {
    Route::get('/{id}', [FieldController::class, 'index'])->middleware(['permission:view form']);
    Route::get('/{id}/create', [FieldController::class, 'create'])->middleware(['permission:create form']);
    Route::post('/', [FieldController::class, 'store'])->middleware(['permission:create form']);
    Route::get('/individual/{id}', [FieldController::class, 'show'])->middleware(['permission:view form']);
    Route::get('/individual/{id}/edit', [FieldController::class, 'edit'])->middleware(['permission:edit form']);
    Route::put('/individual/{id}', [FieldController::class, 'update'])->middleware(['permission:edit form']);
    Route::delete('/individual/{id}', [FieldController::class, 'destroy'])->middleware(['permission:delete form']);
    });

Route::prefix('/fields-locations')->middleware(['auth:api'])->group(function () {
    Route::get('/', [FieldLocationController::class, 'index'])->middleware(['permission:view form']);
    Route::get('/create', [FieldLocationController::class, 'create'])->middleware(['permission:create form']);
    Route::post('/', [FieldLocationController::class, 'store'])->middleware(['permission:create form']);
    Route::get('/show', [FieldLocationController::class, 'show'])->middleware(['permission:view form']);
    Route::get('/edit', [FieldLocationController::class, 'edit'])->middleware(['permission:edit form']);
    Route::put('/update', [FieldLocationController::class, 'update'])->middleware(['permission:edit form']);
    Route::delete('/delete', [FieldLocationController::class, 'destroy'])->middleware(['permission:delete form']);
    });

Route::prefix('/fields-values')->middleware(['auth:api'])->group(function () {
    Route::get('/{id}', [FieldListValueController::class, 'index'])->middleware(['permission:view form']);
    Route::get('/{id}/create', [FieldListValueController::class, 'create'])->middleware(['permission:create form']);
    Route::post('/{id}', [FieldListValueController::class, 'store'])->middleware(['permission:create form']);
    Route::get('/individual/{id}', [FieldListValueController::class, 'show'])->middleware(['permission:view form']);
    Route::get('/individual/{id}/edit', [FieldListValueController::class, 'edit'])->middleware(['permission:edit form']);
    Route::put('/individual/{id}', [FieldListValueController::class, 'update'])->middleware(['permission:edit form']);
    Route::delete('/individual/{id}', [FieldListValueController::class, 'destroy'])->middleware(['permission:delete form']);
    });

Route::prefix('/processes')->middleware(['auth:api'])->group(function () {
    Route::get('/', [ProcessController::class, 'index'])->middleware(['permission:view process']);
    Route::get('/create', [ProcessController::class, 'create'])->middleware(['permission:create process']);
    Route::post('/', [ProcessController::class, 'store'])->middleware(['permission:create process']);
    Route::get('/{id}', [ProcessController::class, 'show'])->middleware(['permission:view process']);
    Route::get('/{id}/edit', [ProcessController::class, 'edit'])->middleware(['permission:edit process']);
    Route::put('/{id}', [ProcessController::class, 'update'])->middleware(['permission:edit process']);
    Route::delete('/{id}', [ProcessController::class, 'destroy'])->middleware(['permission:delete process']);
    });

Route::prefix('/activities')->middleware(['auth:api'])->group(function () {
    Route::get('/{id}', [ActivityController::class, 'index'])->middleware(['permission:view process']);
    Route::get('/{id}/create', [ActivityController::class, 'create'])->middleware(['permission:create process']);
    Route::post('/', [ActivityController::class, 'store'])->middleware(['permission:create process']);
    Route::get('/individual/{id}', [ActivityController::class, 'show'])->middleware(['permission:view process']);
    Route::get('/individual/{id}/edit', [ActivityController::class, 'edit'])->middleware(['permission:edit process']);
    Route::put('/individual/{id}', [ActivityController::class, 'update'])->middleware(['permission:edit process']);
    Route::delete('/individual/{id}', [ActivityController::class, 'destroy'])->middleware(['permission:delete process']);
    });

Route::prefix('/activities-locations')->middleware(['auth:api'])->group(function () {
    Route::get('/', [ActivityLocationController::class, 'index'])->middleware(['permission:view process']);
    Route::get('/create', [ActivityLocationController::class, 'create'])->middleware(['permission:create process']);
    Route::post('/', [ActivityLocationController::class, 'store'])->middleware(['permission:create process']);
    Route::get('/show', [ActivityLocationController::class, 'show'])->middleware(['permission:view process']);
    Route::get('/edit', [ActivityLocationController::class, 'edit'])->middleware(['permission:edit process']);
    Route::put('/update', [ActivityLocationController::class, 'update'])->middleware(['permission:edit process']);
    Route::delete('/delete', [ActivityLocationController::class, 'destroy'])->middleware(['permission:delete process']);
    });

Route::prefix('/activities-relations')->middleware(['auth:api'])->group(function () {
    Route::get('/', [ActivityRelationController::class, 'index'])->middleware(['permission:view process']);
    Route::get('/create', [ActivityRelationController::class, 'create'])->middleware(['permission:create process']);
    Route::post('/', [ActivityRelationController::class, 'store'])->middleware(['permission:create process']);
    Route::get('/{id}', [ActivityRelationController::class, 'show'])->middleware(['permission:view process']);
    Route::get('/{id}/edit', [ActivityRelationController::class, 'edit'])->middleware(['permission:edit process']);
    Route::put('/{id}', [ActivityRelationController::class, 'update'])->middleware(['permission:edit process']);
    Route::delete('/{id}', [ActivityRelationController::class, 'destroy'])->middleware(['permission:delete process']);
    });

Route::prefix('/conditions')->middleware(['auth:api'])->group(function () {
    Route::get('/', [ConditionController::class, 'index'])->middleware(['permission:view process']);
    Route::get('/create', [ConditionController::class, 'create'])->middleware(['permission:create process']);
    Route::post('/', [ConditionController::class, 'store'])->middleware(['permission:create process']);
    Route::get('/{id}', [ConditionController::class, 'show'])->middleware(['permission:view process']);
    Route::get('/{id}/edit', [ConditionController::class, 'edit'])->middleware(['permission:edit process']);
    Route::put('/{id}', [ConditionController::class, 'update'])->middleware(['permission:edit process']);
    Route::delete('/{id}', [ConditionController::class, 'destroy'])->middleware(['permission:delete process']);
    });

Route::prefix('/participants')->middleware(['auth:api'])->group(function () {
    Route::get('/', [ParticipantController::class, 'index'])->middleware(['permission:view process']);
    Route::get('/create', [ParticipantController::class, 'create'])->middleware(['permission:create process']);
    Route::post('/', [ParticipantController::class, 'store'])->middleware(['permission:create process']);
    Route::get('/{id}', [ParticipantController::class, 'show'])->middleware(['permission:view process']);
    Route::get('/{id}/edit', [ParticipantController::class, 'edit'])->middleware(['permission:edit process']);
    Route::put('/{id}', [ParticipantController::class, 'update'])->middleware(['permission:edit process']);
    Route::delete('/{id}', [ParticipantController::class, 'destroy'])->middleware(['permission:delete process']);
    });

Route::prefix('/datalist')->middleware(['auth:api'])->group(function () {
        Route::get('/', [DataListController::class, 'index'])->middleware(['permission:view datalist']);
        Route::get('/create', [DataListController::class, 'create'])->middleware(['permission:create datalist']);
        Route::post('/', [DataListController::class, 'store'])->middleware(['permission:create datalist']);
        Route::get('/{id}', [DataListController::class, 'show'])->middleware(['permission:view datalist']);
        Route::get('/{id}/edit', [DataListController::class, 'edit'])->middleware(['permission:edit datalist']);
        Route::put('/{id}', [DataListController::class, 'update'])->middleware(['permission:edit datalist']);
        Route::delete('/{id}', [DataListController::class, 'destroy'])->middleware(['permission:delete datalist']);
    });

Route::prefix('/datalist-item')->middleware(['auth:api'])->group(function () {
        Route::get('/', [DataListItemController::class, 'index'])->middleware(['permission:view datalist']);
        Route::get('/create', [DataListItemController::class, 'create'])->middleware(['permission:create datalist']);
        Route::post('/', [DataListItemController::class, 'store'])->middleware(['permission:create datalist']);
        Route::get('/{id}', [DataListItemController::class, 'show'])->middleware(['permission:view datalist']);
        Route::get('/{id}/edit', [DataListItemController::class, 'edit'])->middleware(['permission:edit datalist']);
        Route::put('/{id}', [DataListItemController::class, 'update'])->middleware(['permission:edit datalist']);
        Route::put('/order/{id}', [DataListItemController::class, 'updateOrder'])->middleware(['permission:edit datalist']);
        Route::delete('/{id}', [DataListItemController::class, 'destroy'])->middleware(['permission:delete datalist']);
    });

Route::prefix('/datalist-filter')->middleware(['auth:api'])->group(function () {
        Route::get('/', [DataListFilterController::class, 'index'])->middleware(['permission:view datalist']);
        Route::get('/create', [DataListFilterController::class, 'create'])->middleware(['permission:create datalist']);
        Route::post('/', [DataListFilterController::class, 'store'])->middleware(['permission:create datalist']);
        Route::get('/{id}', [DataListFilterController::class, 'show'])->middleware(['permission:view datalist']);
        Route::get('/{id}/edit', [DataListFilterController::class, 'edit'])->middleware(['permission:edit datalist']);
        Route::put('/{id}', [DataListFilterController::class, 'update'])->middleware(['permission:edit datalist']);
        Route::put('/order/{id}', [DataListFilterController::class, 'updateOrder'])->middleware(['permission:edit datalist']);
        Route::delete('/{id}', [DataListFilterController::class, 'destroy'])->middleware(['permission:delete datalist']);
    });

Route::prefix('/datalist-action')->middleware(['auth:api'])->group(function () {
        Route::get('/', [DataListActionController::class, 'index'])->middleware(['permission:view datalist']);
        Route::get('/create', [DataListActionController::class, 'create'])->middleware(['permission:create datalist']);
        Route::post('/', [DataListActionController::class, 'store'])->middleware(['permission:create datalist']);
        Route::get('/{id}', [DataListActionController::class, 'show'])->middleware(['permission:view datalist']);
        Route::get('/{id}/edit', [DataListActionController::class, 'edit'])->middleware(['permission:edit datalist']);
        Route::put('/{id}', [DataListActionController::class, 'update'])->middleware(['permission:edit datalist']);
        Route::put('/order/{id}', [DataListActionController::class, 'updateOrder'])->middleware(['permission:edit datalist']);
        Route::delete('/{id}', [DataListActionController::class, 'destroy'])->middleware(['permission:delete datalist']);
    });

// Route::prefix('/roles')->group(function () {
//     Route::get('/', [RoleController::class, 'index'])->middleware(['permissions:view role']);
//     Route::get('/create', [RoleController::class, 'create'])->middleware(['permissions:create role']);
//     Route::post('/', [RoleController::class, 'store'])->middleware(['permissions:create role']);
//     Route::get('/{id}', [RoleController::class, 'show'])->middleware(['permissions:view role']);
//     Route::get('/{id}/edit', [RoleController::class, 'edit'])->middleware(['permissions:edit role']);
//     Route::put('/{id}', [RoleController::class, 'update'])->middleware(['permissions:edit role']);
//     Route::delete('/{id}', [RoleController::class, 'destroy'])->middleware(['permissions:delete role']);
// });
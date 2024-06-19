<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleAndPermissionController;

// Authentication Routes
Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register'])->name('register');

    Route::middleware('auth:api')->group(function () {
        Route::get('/me', [AuthController::class, 'me'])->name('me');
        Route::post('/out', [AuthController::class, 'logout'])->name('logout');
        Route::get('/tokens', [AuthController::class, 'tokens'])->name('tokens');
        Route::post('/out_all', [AuthController::class, 'logoutAll'])->name('logoutAll');
    });
});

// Protected Routes
Route::middleware('auth:api')->group(function () {

    // User Routes
    Route::prefix('ref/user')->group(function () {
        Route::get('/', [UserController::class, 'getUsers']);
        Route::get('{id}/role', [UserController::class, 'getUserRoles']);
        Route::post('{id}/role', [UserController::class, 'giveUserRoles']);
        Route::delete('{id}/role/{roleId}', [UserController::class, 'hardDeleteUserRole']);
        Route::delete('{id}/role/{roleId}/soft', [UserController::class, 'softDeleteUserRole']);
        Route::post('{id}/role/{roleId}/restore', [UserController::class, 'restoreDeletedUserRole']);
    });

    // Role Routes
    Route::prefix('ref/policy/role')->group(function () {
        Route::get('/', [RoleController::class, 'getAllRoles']);
        Route::get('/{id}', [RoleController::class, 'getRole']);
        Route::post('/', [RoleController::class, 'createRole']);
        Route::put('/{id}', [RoleController::class, 'updateRole']);
        Route::delete('/{id}', [RoleController::class, 'deleteRole']);
        Route::delete('/{id}/soft', [RoleController::class, 'softDeleteRole']);
        Route::post('/{id}/restore', [RoleController::class, 'restoreRole']);
    });

    // Permission Routes
    Route::prefix('ref/policy/permission')->group(function () {
        Route::get('/', [PermissionController::class, 'getAllPermissions']);
        Route::get('/{id}', [PermissionController::class, 'getPermission']);
        Route::post('/', [PermissionController::class, 'createPermission']);
        Route::put('/{id}', [PermissionController::class, 'updatePermission']);
        Route::delete('/{id}', [PermissionController::class, 'deletePermission']);
        Route::delete('/{id}/soft', [PermissionController::class, 'softDeletePermission']);
        Route::post('/{id}/restore', [PermissionController::class, 'restorePermission']);
    });

    // Role and Permission Routes
    Route::prefix('ref/policy/roles-and-permissions')->group(function () {
        Route::post('/', [RoleAndPermissionController::class, 'createRoleAndPermission']);
        Route::get('/', [RoleAndPermissionController::class, 'getAllRolesAndPermissions']);
        Route::get('/{id}', [RoleAndPermissionController::class, 'getRoleAndPermission']);
        Route::put('/{id}', [RoleAndPermissionController::class, 'updateRoleAndPermission']);
        Route::delete('/{id}', [RoleAndPermissionController::class, 'deleteRoleAndPermission']);
    });
});

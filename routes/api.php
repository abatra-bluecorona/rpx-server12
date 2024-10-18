<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LicenseController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\GitHubWebhookController;

// Group routes under API versioning for v1
Route::prefix('v1')->group(function () {
    // Route to create a new client
    Route::post('/create-client', [ClientController::class, 'store'])->middleware('auth:sanctum');

    Route::post('/github-webhook', [GitHubWebhookController::class, 'handleWebhook']);

    // Route to log in and get access token
    // Route::post('/login', [LoginController::class, 'login']); // New route for login

    // New route for API login
    // Route::post('/login', [AuthenticatedSessionController::class, 'apiStore']); // API login route
    
    // Route to validate the license (rpx_token)
    Route::get('/validate-license', [LicenseController::class, 'validateLicense']);
    
    // Route to check for product updates
    Route::get('/check-updates', [LicenseController::class, 'checkUpdates']);
    
    
    // Route to fetch shared secrets
    Route::get('/shared-secrets', [LicenseController::class, 'fetchSharedSecrets']);
    
    // Sanctum authenticated user info
    Route::get('/user', function (Request $request) {
        return $request->user();
    })->middleware('auth:sanctum');
});

<?php

use App\Http\Controllers\Tools\Osint\AdhaarInfoController;

// ... other existing routes ...

Route::middleware(['web', 'auth'])->group(function () {
    // OSINT Tools Routes
    Route::prefix('osint/tools')->name('osint-tools.')->group(function () {
        // Aadhaar Info Routes
        Route::get('/adhaar/info', [AdhaarInfoController::class, 'index'])->name('adhaar-info');
        Route::post('/adhaar/check', [AdhaarInfoController::class, 'check'])->name('adhaar-check');
    });
});

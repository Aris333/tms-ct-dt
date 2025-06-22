<?php

use App\Http\Controllers\LocaleController;
use App\Http\Controllers\TranslationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// language
Route::prefix('locales')->group(function () {
    Route::get('/', [TranslationController::class, 'export']);
    Route::get('/', [LocaleController::class, 'index']);
    Route::post('/', [LocaleController::class, 'store']);
    Route::prefix('{locale:id}')->group(function () {
        Route::post('/', [LocaleController::class, 'update']);
        Route::delete('/', [LocaleController::class, 'destroy']);
        // translations
        Route::prefix('translations')->group(function () {
            Route::get('/', [TranslationController::class, 'index']);
            Route::post('/', [TranslationController::class, 'store']);
            Route::prefix('{translation:id}')->group(function () {
                Route::post('/', [TranslationController::class, 'update']);
                Route::delete('/', [TranslationController::class, 'destroy']);
            });
        });
    });
});

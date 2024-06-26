<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PersonController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('people', PersonController::class);
    Route::apiResource('people.contacts', ContactController::class)->shallow();
    Route::get('brackets', function (Request $request) {
        $string = $request->input('string');
        return validateBrackets($string);
    });
});

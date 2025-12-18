<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use Laravel\Sanctum\Sanctum;

Route::get('/sanctum/csrf-cookie', function () {
    return response()->json(['message' => 'CSRF cookie set']);
});


Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

<?php

use Illuminate\Http\Request;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\AlbumController;
use App\Http\Controllers\Api\OptionController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\Page\PageController;
use App\Http\Controllers\Api\Page\PublicPageController;

/*
Route::get('/sanctum/csrf-cookie', function () {
    return response()->json(['message' => 'CSRF cookie set']);
});
*/

Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {   return $request->user();    });
    
    Route::get('/dashboard/stats', [DashboardController::class, 'stats']);

    Route::get('/pages', [PageController::class, 'index']);
    Route::post('/pages', [PageController::class, 'store']);
    Route::get('/pages/{id}', [PageController::class, 'show']);
    Route::put('/pages/{id}', [PageController::class, 'update']);

    Route::apiResource('albums', AlbumController::class);

    Route::get('/options', [OptionController::class, 'index']);

    Route::get('/pages-menu', [PageController::class, 'pages_menu']);
    Route::apiResource('menus', MenuController::class);
    Route::patch('/menus/{menu}/activate', [MenuController::class, 'setActive']);
});

//public
Route::get('/public/pages/{slug}', [PublicPageController::class, 'show']);
Route::get('/public/menus/active', [PublicPageController::class, 'active']);
Route::get('/public/footer', [PublicPageController::class, 'footer']);
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Artisan; // Import Artisan if not already imported


Route::middleware('auth:sanctum')->put('/user', [AuthController::class, 'update']);


Route::get('/',function(Request $request){
    return 'API';
});


Route::post('/register',[AuthController::class, 'register']);
Route::post('/login',[AuthController::class, 'login']);
Route::post('/logout',[AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/edit_user',[AuthController::class, 'editUser'])->middleware('auth:sanctum');
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/run-migrations', function (Request $request) {
    if ($request->input('key') !== 'aosobila') {
        abort(403);
    }
    Artisan::call('migrate', ['--force' => true]);
    return 'Migrations completed.';
});

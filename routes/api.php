<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Artisan; // Import Artisan if not already imported and need to migrate
use App\Models\Work; // Import the Work model
use App\Models\TeamMember; // Import the TeamMember model

Route::middleware('auth:sanctum')->put('/user', [AuthController::class, 'update']);


Route::get('/',function(Request $request){
    return 'API';
});

# Auth
Route::post('/register',[AuthController::class, 'register']);
Route::post('/login',[AuthController::class, 'login']);
Route::post('/logout',[AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/edit_user',[AuthController::class, 'editUser'])->middleware('auth:sanctum');
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/users/{user}/photo', [UserController::class, 'updatePhoto'])->middleware('auth:sanctum');
Route::post('/user/photo', [UserController::class, 'updatePhoto'])->middleware('auth:sanctum');
Route::get('/user/photo/{filename}', [UserController::class, 'servePhoto']);

// Route to get all works
Route::get('/works', function () {
    return Work::all(); // Retrieve all works from the database
});

// Route to get all team members
Route::get('/team-members', function () {
    return TeamMember::all(); // Retrieve all team members from the database
});


# remove it later with the import(use) for better performance
Route::get('/run-migrations', function (Request $request) {
    if ($request->input('key') !== '3545gf!@#') {
        abort(403);
    }
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('migrate:fresh', ['--force' => true]);
    return 'Migrations and caching cleared and fresh migrations completed.';
});
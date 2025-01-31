<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([
    'prefix' => 'auth',
], function () {
    Route::post('logout', [AuthController::class,'logout'])->middleware('jwt');
    Route::post('login', [AuthController::class,'login']);
});
Route::group([
    'prefix' => 'books',
    'middleware' => ['api', 'jwt']
], function () {
    Route::get('/', [BookController::class,'index']);
    Route::post('/', [BookController::class,'store']);
    Route::patch('/{book}', [BookController::class,'update']);
    Route::delete('/{book}', [BookController::class,'destroy']);
});
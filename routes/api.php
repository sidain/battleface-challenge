<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/login', function(Request $request){
    $credentials = request()->only( ['email', 'password'] );
    $token = auth()->attempt($credentials);
    return $token;
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);

    Route::get('quotations',  [QuotationController::class, 'index']);
    Route::get('quotations/{id}',  [QuotationController::class, 'show']);
    Route::post('quotations',  [QuotationController::class, 'store']);
    Route::put('quotations/{id}',  [QuotationController::class, 'update']);
    Route::delete('quotations/{id}',  [QuotationController::class, 'delete']);
});

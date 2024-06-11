<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\AdminController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['middleware' => 'api'], function () {
    Route::post('/admin/register', [AdminController::class, 'register'])->middleware('AdminAuth:register')->name('admin.register');

    Route::post('/admin/login', [AdminController::class, 'login'])->middleware('AdminAuth:login')->name('admin.login');

    Route::post('/vendor/register', [VendorController::class, 'register'])->middleware('VendorAuth:register')->name('vendor.login');

});










// Route::get('/test', function () {
//     return response()->json(['message' => 'success'], 201);
// });

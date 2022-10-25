<?php

use App\Http\Controllers\Api\admin\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\users\UserController;
use Illuminate\Support\Facades\Auth;

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
//   return $request->user();
// });


Route::group(['middleware' => ['api', 'ChangeLanguage']], function () {
  Route::post('get_all_categories', [CategoriesController::class, 'index']);
  Route::post('get_category', [CategoriesController::class, 'get_category']);
  Route::post('change_status', [CategoriesController::class, 'change_status']);

  Route::group(['prefix' => 'admin'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware(['JwtAuthGuard:admin_api']);


    Route::post('profile', function () {
      return Auth::user();
    })->middleware(['JwtAuthGuard:admin_api']);
  });


  Route::group(['prefix' => 'user', 'middleware' => 'JwtAuthGuard:user_api'], function () {
    Route::post('profile', function () {
      return Auth::user();
    });
  });




  Route::group(['prefix' => 'user'], function () {
    Route::post('login', [UserController::class, 'login']);
  });
});








Route::group(['middleware' => ['api', 'ChangeLanguage', 'CheckAdmin:admin_api']], function () {
  Route::get('offers', [CategoriesController::class, 'index']);
});

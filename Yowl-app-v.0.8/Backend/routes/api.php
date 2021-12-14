<?php

use App\Http\Controllers\v1\ProviderAuthController;
use App\Http\Controllers\v1\AuthController;
use App\Http\Controllers\v1\ReviewController;
use App\Http\Controllers\v1\CommentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProviderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::get('user', [UserController::class, 'index']);
Route::post('user/{id}', [UserController::class, 'update']);
Route::get('provider', [ProviderController::class, 'index']);
       
Route::prefix('v1')->group(function () {
    //Prefijo V1, todo lo que este dentro de este grupo se accedera escribiendo v1 en el navegador, es decir /api/v1/*
    Route::post('login', [AuthController::class, 'authenticate']);
    Route::post('register', [AuthController::class, 'register']);
   

    Route::post('/provider/login', [ProviderAuthController::class, 'authenticate']);
    Route::post('provider/register', [ProviderAuthController::class, 'register']);
    

    Route::get('review/index', [ReviewController::class, 'index']);
    Route::get('review/{id}', [ReviewController::class, 'show']);
    Route::post('review', [ReviewController::class, 'store']);
    Route::put('review/{id}', [ReviewController::class, 'update']);
    Route::delete('review/{id}', [ReviewController::class, 'destroy']);


    Route::get('comment/index', [CommentController::class, 'index']);
    Route::get('comment/{id}', [CommentController::class, 'show']);
    Route::post('comment', [CommentController::class, 'store']);
    Route::put('comment/{id}', [CommentController::class, 'update']);
    Route::delete('comment/{id}', [CommentController::class, 'destroy']);


    Route::group(['middleware' => ['jwt.verify']], function () {
        //Todo lo que este dentro de este grupo requiere verificación de usuario.
        
       

        

        
        Route::post('user', [UserController::class, 'store']);
        Route::put('user/{id}', [UserController::class, 'update']);
        Route::delete('user/{id}', [UserController::class, 'destroy']);

        Route::post('provider', [ProviderController::class, 'store']);
        Route::put('provider/{id}', [ProviderController::class, 'update']);
        Route::delete('provider/{id}', [ProviderController::class, 'destroy']);
    });
});

////////////////////////77777777777777777777777777777777777
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

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */

////////////////////////777777777777777777777777777777777777
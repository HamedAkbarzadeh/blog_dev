<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Api\ApiLikeController;
use App\Http\Controllers\api\auth\AuthController;
use App\Http\Controllers\api\admin\PostController;
use App\Http\Controllers\Api\ApiCommentController;
use App\Http\Controllers\Api\ApiProductController;

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

// public Route

        // http://127.0.0.1:8000/api/register  method: post  .... For Register New User
    Route::post('/register' , [AuthController::class , 'register']);

        // http://127.0.0.1:8000/api/login  method: post  .... For Login User
    Route::post('/login' , [AuthController::class , 'login']);

// Route::apiResource('post',PostController::class);

Route::prefix('post')->group( function() {

        // http://127.0.0.1:8000/api/post  method: get  .... Get All Post
    Route::get('/',[PostController::class , 'index']);

        // http://127.0.0.1:8000/api/post/id  method: get  .... Find Post With id
    Route::get('/{post}',[PostController::class , 'show']);

        // http://127.0.0.1:8000/api/post/store  method: sotre  .... Insert New Post
    Route::post('/store',[PostController::class , 'store']);

        // http://127.0.0.1:8000/api/post/update/id  method: put  .... Update Post
    Route::put('/update/{post}',[PostController::class , 'update']);

        // http://127.0.0.1:8000/api/post/destroy/id  method: delete  .... Delete Post
     Route::delete('/destroy/{post}',[PostController::class , 'destroy']);

        // http://127.0.0.1:8000/api/post/search/title  method: get  .... Search Post With title
     Route::get('/search/{title}',[PostController::class , 'search']);
});


        // http://127.0.0.1:8000/api/post/newPost  method: get  .... Get 15 New Post
    Route::get('newPost',[ApiProductController::class, 'orderById']);

        // http://127.0.0.1:8000/api/post/randomPost  method: get  .... Get 15 Random Post
    Route::get('randomPost',[ApiProductController::class, 'randomProduct']);

    // <............................>
        // http://127.0.0.1:8000/api/post/comment  method: get  .... All Comment
        // http://127.0.0.1:8000/api/post/comment/store  method: post  .... For Insert Comment
        // http://127.0.0.1:8000/api/post/comment/update  method: put  .... For Update Comment
        // http://127.0.0.1:8000/api/post/comment/destroy  method: delete  .... For Delete Comment
    Route::apiResource('comment',ApiCommentController::class);
    // <............................>


        // http://127.0.0.1:8000/api/post/{id}/comment  method: get  .... For Find How Many Have Comment One Post
    Route::get('/post/{id}/comment',[ApiCommentController::class, 'AllCommentPost']);

        // http://127.0.0.1:8000/api/post/{id}/comment/{id}  method: get  .... For Find Comment Belongs to Post
    Route::get('/post/{id}/comment/{idComment}',[ApiCommentController::class, 'show']);


// protected Route
Route::group(['middleware' => ['auth:sanctum']],function (){

        // http://127.0.0.1:8000/api/logout  method: post  .... For Logout User
    Route::post('/logout' , [AuthController::class , 'logout']);

            // http://127.0.0.1:8000/api/refresh  method: get  .... For refresh token
            Route::get('/refresh' , [AuthController::class , 'refresh']);

        // http://127.0.0.1:8000/api/dashboard  method: post  .... 
    Route::prefix('/dashboard')->group(function () {

            // http://127.0.0.1:8000/api/dashboard/user/{id user}  method: post  .... For Show Information User
        Route::get('/user' , [DashboardController::class , 'user']);

            // http://127.0.0.1:8000/api/dashboard/user/update  method: put  .... For Update Information User
        Route::put('/user/update' , [DashboardController::class , 'userUpdate']);
    });
});

        // http://127.0.0.1:8000/api/pLikeComment/{id Comment}  method: get  .... For Pluse Like Comment
Route::get('pLikeComment/{id}',[ApiLikeController::class, 'plusLikeComment']);

        // http://127.0.0.1:8000/api/mLikeComment/{id Comment}  method: get  .... For Minus Like Comment
Route::get('mLikeComment/{id}',[ApiLikeController::class, 'minusLikeComment']);

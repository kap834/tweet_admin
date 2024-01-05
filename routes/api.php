<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;

Route::post('user/register', [ApiController::class, 'register']);
Route::post('user/login', [ApiController::class, 'login']);
Route::post('user/post', [ApiController::class, 'post']);
Route::get('user/posts', [ApiController::class, 'posts']);

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/posts',[\App\Http\Controllers\PostController::class, 'create'])->name('post-create');
Route::post('/posts/{id}',[\App\Http\Controllers\PostController::class, 'edit'])->name('post-edit');
Route::delete('/posts/{id}',[\App\Http\Controllers\PostController::class, 'delete'])->name('post-delete');
Route::get('/posts',[\App\Http\Controllers\PostController::class, 'allPosts'])->name('post-allPosts');
Route::get('/posts/{id}',[\App\Http\Controllers\PostController::class, 'find'])->name('post-find');
Route::post('/posts/{id}/comments',[\App\Http\Controllers\PostController::class, 'comment'])->name('post-comment');
Route::delete('/posts/{id}/comments/{id2}',[\App\Http\Controllers\PostController::class, 'deleteComment'])->name('post-deleteComment');
Route::get('/posts/tag/{tag}',[\App\Http\Controllers\PostController::class, 'findTag'])->name('post-findTag');

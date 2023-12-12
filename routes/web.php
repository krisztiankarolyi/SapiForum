<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Auth::routes();
Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/myPosts', [UserController::class, 'myPosts'])->name('myPosts');
    Route::get('/posts', [UserController::class, 'posts'])->name('posts');

    Route::post('/storePost', [UserController::class, 'storePost'])->name('storePost');
    Route::get('/createPost', [UserController::class, 'createPost'])->name('createPost');

    Route::get('/editPost/{id}', [UserController::class, 'editPost'])->name('editPost');
    Route::post('/updatePost', [UserController::class, 'updatePost'])->name('updatePost');

    Route::delete('/deletePost/{id}', [UserController::class, 'deletePost'])->name('deletePost');

    Route::get('/editProfile', [UserController::class, 'editProfile'])->name('editProfile');
    Route::post('/updateProfile', [UserController::class, 'updateProfile'])->name('updateProfile');

    Route::get('/viewPost/{id}', [Controller::class, 'viewPost'])->name('viewPost');

    Route::post('/addComment', [UserController::class, 'addComment'])->name('addComment');
    Route::delete('/deleteComment', [UserController::class, 'deleteComment'])->name('deleteComment');


});

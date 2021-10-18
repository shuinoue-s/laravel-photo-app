<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\ShowController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PasswordChangeController;
use App\Http\Controllers\EmailChangeController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [ShowController::class, 'index'])->name('index');

Route::get('/post/show/{id}', [ShowController::class, 'show'])->where('id', '[0-9]+')->name('post.show');

Route::delete('/post/destroy/{id}', [ShowController::class, 'destroy'])->where('id', '[0-9]+')->name('post.destroy');

Route::get('/post/form', [PostController::class, 'form'])->name('post.form');

Route::post('/post/upload', [PostController::class, 'upload'])->name('post.upload');

Route::get('/post/list', [PostController::class, 'list'])->name('post.list');

Route::post('/comment/create/{id}', [CommentController::class, 'create'])->where('id', '[0-9]+')->name('comment.create');

Route::delete('/comment/destroy/{id}', [CommentController::class, 'destroy'])->where('id', '[0-9]+')->name('comment.destroy');

Route::get('/post/show/{post?}/firstcheck', [LikeController::class, 'firstcheck'])->name('like.firstcheck');

Route::get('/post/show/{post?}/check', [LikeController::class, 'check'])->name('like.check');

Route::get('/tag/list/{id}', [TagController::class, 'list'])->name('tag.list');

Route::get('/tag/search', [TagController::class, 'search'])->name('tag.search');

Route::get('/tag/result', [TagController::class, 'result'])->name('tag.result');

Route::get('/mypage/profile', [ProfileController::class, 'profile'])->name('mypage.profile');

Route::get('/mypage/edit', [ProfileController::class, 'edit'])->name('mypage.edit');

Route::post('/mypage/create', [ProfileController::class, 'create'])->name('mypage.create');

Route::delete('mypage/destroy/{id}', [ProfileController::class, 'destroy'])->where('id', '[0-9]+')->name('mypage.destroy');

Route::get('/mypage/passwordchange_show', [PasswordChangeController::class, 'passwordChangeShow'])->name('mypage.passwordchange_show');

Route::patch('/mypage/passwordchange', [PasswordChangeController::class, 'passwordChange'])->name('mypage.passwordchange');

Route::get('/mypage/emailchange_show', [EmailChangeController::class, 'emailChangeShow'])->name('mypage.emailchange_show');

Route::patch('/mypage/emailchange', [EmailChangeController::class, 'emailChange'])->name('mypage.emailchange');

Route::get('/mypage/reset/{token}', [EmailChangeController::class, 'emailReset'])->name('mypage.emailreset');

Route::get('/logout', [UserController::class, 'getLogout'])->name('user.logout');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationController;
//Asosiy
Route::get('/',[MainController::class,'dashboard'])->name('home')->middleware('register');
Route::get('Mainpage',[MainController::class,'index'])->name('main');
//User Yaratish Login Qilish
Route::get('/register',[AuthController::class,'registerForm'])->name('registerForm');
Route::get('/email-verify',[AuthController::class,'emailVerify'])->name('email.verify');
Route::post('/register',[AuthController::class,'register'])->name('register');
Route::get('/login',[AuthController::class,'loginForm'])->name('loginForm');
Route::post('login',[AuthController::class,'login'])->name('login');
Route::get('edituser/',[AuthController::class,'editForm'])->name('editprofile');
Route::put('updateuser',[AuthController::class,'update'])->name('update.profile');
Route::get('/user/profile',[AuthController::class,'userprofile'])->name('users.profile');
Route::get('my/profile',[AuthController::class,'my_profile'])->name('my.profile');
Route::delete('/logout',[AuthController::class,'logout'])->name('logout');
Route::post( '/comments/store', [CommentController::class, 'store'])->name('comments.store');
Route::delete( '/comments/destroy/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');

Route::patch('/read/notify{id}', [NotificationController::class,'readNotify'])->name('mark.notification.read');
//Postlar Uchun
Route::resource( '/posts', PostController::class);
Route::get('/posts', [PostController::class,'index'])->name('posts.index');
Route::get('/posts/{post}', [PostController::class,'show'])->name('posts.show');

//Follow va notify uchun
Route::post('/follow/{id}',[FollowController::class,'follow'])->name('follow');
Route::delete('/follow/{id}', [FollowController::class, 'unfollow'])->name('unfollow');
Route::get('/notify',[FollowController::class,'notify'])->name('notify');
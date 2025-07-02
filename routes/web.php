<?php

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
Route::get('/', function () {
    return view('welcome');
});

Route::get('/posts/my-posts', [PostController::class, 'myPosts'])->middleware(['auth', 'verified'])->name('posts.myPosts');
Route::get('/comments/my-comments', [CommentController::class, 'myComments'])->middleware(['auth', 'verified'])->name('comments.myComments');

Route::get('/dashboard', function () {
    $user = Auth::user();
    if ($user->role === 'admin') {
        return view('admin.dashboard');
    }
     return redirect()->route('posts.index');
})->middleware(['auth', 'verified'])->name('dashboard');




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile', [ProfileController::class, 'profilepic'])->name('profile.profilepic');
});

Route::resource('posts', PostController::class)->middleware(['auth', 'verified']);
// routes/web.php
//Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');

Route::resource('comments', CommentController::class)->middleware(['auth', 'verified']);

require __DIR__.'/auth.php';

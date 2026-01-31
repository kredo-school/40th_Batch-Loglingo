<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\DiscussionController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [PostController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('posts', PostController::class); // view create edit
    Route::resource('questions', QuestionController::class); // Q&A things
    Route::get('/search', [SearchController::class, 'index'])->name('search');
    Route::resource('discussions', DiscussionController::class);
});

Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/', [AdminController::class, 'indexUsers'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'indexUsers'])->name('users.index');
    Route::get('/teachers', [AdminController::class, 'indexTeachers'])->name('teachers.index');
    Route::get('/posts', [AdminController::class, 'indexPosts'])->name('posts.index');
    Route::get('/qna', [AdminController::class, 'indexQna'])->name('qna.index');
    Route::get('/tags', [AdminController::class, 'indexTags'])->name('tags.index');
    Route::get('/discussions', [AdminController::class, 'indexDiscussions'])->name('discussions.index');
});

require __DIR__ . '/auth.php';

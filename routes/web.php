<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\DiscussionController;
use App\Http\Controllers\FollowController;


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

    // FOLLOW
    Route::post('/follow/{user}/store', [FollowController::class, 'store'])->name('follow.store');
    Route::delete('/follow/{user}/destroy', [FollowController::class, 'destroy'])->name('follow.destroy');

    // Profile tabs
    Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show'); //default. (dashboard = post tab)
    Route::get('/profile/{user}/questions', [ProfileController::class, 'questions'])->name('profile.questions');
    Route::get('/profile/{user}/following', [ProfileController::class, 'following'])->name('profile.following');
    Route::get('/profile/{user}/followers', [ProfileController::class, 'followers'])->name('profile.followers');

    // See more
    Route::get('/posts/all', [PostController::class, 'all'])->name('posts.all');
    Route::get('/questions/all', [QuestionController::class, 'all'])->name('questions.all');
    Route::get('/discussions/all', [DiscussionController::class, 'all'])->name('discussions.all');

    // Resource
    Route::resource('posts', PostController::class);
    Route::resource('questions', QuestionController::class);
    Route::resource('comments', CommentController::class);
    Route::resource('answers', AnswerController::class);
    Route::resource('discussions', DiscussionController::class);

    Route::get('/search', [SearchController::class, 'index'])->name('search');

    // report
    Route::post('/report', [ReportController::class, 'store'])
        // ->middleware('auth')
        ->name('report.store');



    });


    




//admin 
Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/', [AdminController::class, 'indexUsers'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'indexUsers'])->name('users.index');
    Route::get('/teachers', [AdminController::class, 'indexTeachers'])->name('teachers.index');
    Route::get('/posts', [AdminController::class, 'indexPosts'])->name('posts.index');
    Route::get('/qna', [AdminController::class, 'indexQna'])->name('qna.index');
    Route::get('/tags', [AdminController::class, 'indexTags'])->name('tags.index');
    Route::post('/tags', [AdminController::class, 'storeTag'])->name('tags.store');
    Route::get('/discussions', [AdminController::class, 'indexDiscussions'])->name('discussions.index');
});

require __DIR__ . '/auth.php';

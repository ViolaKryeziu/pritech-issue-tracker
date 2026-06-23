<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\IssueController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::resource('projects', ProjectController::class);
    Route::resource('issues', IssueController::class);
    Route::resource('tags', TagController::class)->only([
        'index',
        'store',
        'destroy'
    ]);

    Route::get('/api/tags', [TagController::class, 'all']);

    Route::post('/issues/{issue}/tags/attach', [TagController::class, 'attach']);
    Route::post('/issues/{issue}/tags/detach', [TagController::class, 'detach']);

    Route::get('/issues/{issue}/comments', [CommentController::class, 'index']);
    Route::post('/issues/{issue}/comments', [CommentController::class, 'store']);

    Route::post('/issues/{issue}/users/attach', [IssueController::class, 'attachUser']);
    Route::post('/issues/{issue}/users/detach', [IssueController::class, 'detachUser']);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

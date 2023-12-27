<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommentController;
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

Route::get('/', function () {
    // return view('welcome');
    return ProfileController::index();

});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/profiles', [ProfileController::class, 'index'])->name('profile.index');
Route::get('/profile/{profile_id}', [ProfileController::class, 'show'])->name('profile.show');

Route::get('/comment/create', [CommentController::class, 'create'])->name('comment.create');
Route::delete('/comment/{comment}}', [CommentController::class,'destroy'])->name('comment.destroy');

Route::get('/comment/showAll/{id}', [CommentController::class, 'showAll'])->name('comment.showAll');

require __DIR__.'/auth.php';

<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\MailController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\HomeController;

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

Route::get('/', function (Request $request) {
    $message = 'Loading welcome page';
    Log::info($message);
    $request->session()->flash('info', $message);
    return view('welcome');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('mail/test', [MailController::class, 'test']);
Route::resource('files', FileController::class)->middleware(['auth', 'role.any:1,2,3']);
Route::resource('posts', PostController::class)->middleware(['auth', 'role.any:1,2,3']);
Route::resource('places', PlaceController::class)->middleware(['auth', 'role.any:1,2,3']);

Route::post('/places/{place}/favorite', [PlaceController::class, 'favorite'])->name('places.favorite')->middleware(['auth', 'role.any:1,2,3']);
Route::delete('/places/{place}/unfavorite', [PlaceController::class, 'unfavorite'])->name('places.unfavorite')->middleware(['auth', 'role.any:1,2,3']);



Route::post('/posts/{post}/likes', [PostController::class, 'like'])->name('posts.like')->middleware(['auth', 'role.any:1,2,3']);
Route::delete('/posts/{post}/likes',[ PostController::class, 'unlike'])->name('posts.unlike')->middleware(['auth', 'role.any:1,2,3']);

require __DIR__.'/auth.php';

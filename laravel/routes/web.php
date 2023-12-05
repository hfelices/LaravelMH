<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\MailController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
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

// Route::get('/', function (Request $request) {
//     $message = 'Loading welcome page';
//     Log::info($message);
//     $request->session()->flash('info', $message);
//     return view('welcome');
// });

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/about_hector', [HomeController::class, 'aboutus'])->name('aboutus');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('mail/test', [MailController::class, 'test']);
Route::resource('files', FileController::class)->middleware(['auth', ]);
Route::resource('posts', PostController::class)->middleware(['auth', ]);
Route::resource('places', PlaceController::class)->middleware(['auth', ]);

Route::post('/places/{place}/favorite', [PlaceController::class, 'favorite'])->name('places.favorite')->middleware('can:update,place');



Route::post('/posts/{post}/likes', [PostController::class, 'like'])->name('posts.like')->middleware(['auth', ]);
Route::delete('/posts/{post}/likes',[ PostController::class, 'unlike'])->name('posts.unlike')->middleware(['auth', ]);

Route::get('/language/{locale}',[LanguageController::class, 'language'])->name('language');

require __DIR__.'/auth.php';

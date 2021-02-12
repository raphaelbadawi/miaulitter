<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\TweetController;
use App\Http\Controllers\MessageController;

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

Route::get('meows', [TweetController::class, 'index'])->name('tweets.index');

Route::group(['middleware' => ['auth:sanctum', 'verified']], function() {
    Route::get('/', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
    Route::get('dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::post('meows', [TweetController::class, 'store'])->name('tweets.store');
    Route::delete('meows/{tweet:id}', [TweetController::class, 'destroy'])->name('tweets.destroy');
    Route::patch('meows/{tweet:id}', [TweetController::class, 'update'])->name('tweets.update');

    Route::get('shag/{shag}', [TweetController::class, 'shag'])->name('shag.show');

    Route::get('follows/{user:id}', [TweetController::class, 'follows'])->name('tweets.follows');
    Route::get('unfollows/{user:id}', [TweetController::class, 'unfollows'])->name('tweets.unfollows');
    Route::get('followings', [TweetController::class, 'followings'])->name('tweets.followings');

    Route::get('messages', [MessageController::class, 'show'])->name('messages.show');
    Route::post('messages', [MessageController::class, 'store'])->name('messages.store');

    Route::get('profile/{user:name}', [TweetController::class, 'profile'])->name('tweets.profile');
});
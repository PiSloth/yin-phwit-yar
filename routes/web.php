<?php

use App\Livewire\YPY\PostsHR;
use App\Livewire\YPY\Publish;
use App\Livewire\YPY\ViewPost;
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

Route::get('/', Publish::class)->middleware('auth')->name('home');
Route::get('post/hr', PostsHR::class)
    ->middleware('auth')
    ->name('post.hr')
    ->can('isHR');

Route::get('/post/detail', ViewPost::class)->middleware('auth')->name('view-post');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';

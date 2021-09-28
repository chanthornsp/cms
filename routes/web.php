<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Models\Article;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/login', [AuthController::class, 'loginUser'])->name('login.user');

Route::post('/register', [AuthController::class, 'create'])->name('create');

Route::get('/dashboard', [DashboardController::class, 'dashboard'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::get('/admin', [AdminController::class, 'index'])
    ->middleware('auth:admin')
    ->name('admin.index');

Route::get('/articles', function () {

    // $article = Article::first();
    // dump($article->title);
    // dump('Created by ' . $article->user->name);
    // dd($article);
    $articles = Article::with('user')->get();
    dd($articles);

    $user = auth()->user();
    // $articles = Article::where('user_id', $user->id)->get()->toArray();
    $articles = $user->articles()
        ->where('id', '>', 3)->get();
});

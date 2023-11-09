<?php

use App\Livewire\ArticleForm;
use App\Livewire\ArticlesTable;
use App\Livewire\ArticleShow;
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

Route::get('/blog/{article}', ArticleShow::class)->name('articles.show');

// Dashboard Routes
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])
    ->prefix('dashboard')->group(function () {

        Route::view('/', 'dashboard')->name('dashboard');

        Route::get('/blog', ArticlesTable::class)->name('articles.index');

        Route::get('/blog/crear', ArticleForm::class)->name('articles.create');

        Route::get('/blog/{article:id}/edit', ArticleForm::class)->name('articles.edit');

    });

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\ArticleController;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// Tests
Route::controller(TestController::class)->group(function (){
    Route::get('/test', 'index')->name('test.index')->middleware(['auth']);
});

// Articles
Route::controller(ArticleController::class)->group(function (){
    Route::get('/articles', 'index')->name('article.index')->middleware(['auth']);
    Route::get('/article/add', 'create')->name('article.add')->middleware(['auth']);
    Route::get('/article/edit/{article_id}', 'edit')->name('article.edit')->middleware(['auth']);
    Route::post('/article/store', 'store')->name('article.store')->middleware(['auth']);
    Route::post('/article/update/{article_id}', 'update')->name('article.update')->middleware(['auth']);
});



// Dashboard
// Route::controller(DashboardController::class)->group(function (){
//     Route::get('/', 'index')->name('welcome')->middleware(['auth']);
// });

require __DIR__.'/auth.php';

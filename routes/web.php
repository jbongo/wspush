<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ScrapController;
use App\Http\Controllers\SiteexterneController;
use App\Http\Controllers\CategorieexterneController;
use App\Http\Controllers\SiteinterneController;
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
    return view('welcome')->middleware(['auth']);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard')->middleware(['auth']);

// Tests
Route::controller(TestController::class)->group(function (){
    Route::get('/test', 'index')->name('test.index')->middleware(['auth']);
});

// Sites externes
Route::controller(SiteexterneController::class)->group(function (){
    Route::get('/site-externes', 'index')->name('site_externe.index')->middleware(['auth']);
    Route::get('/site-externe/add', 'create')->name('site_externe.add')->middleware(['auth']);
    Route::get('/site-externe/edit/{site_id}', 'edit')->name('site_externe.edit')->middleware(['auth']);
    Route::post('/site-externe/store', 'store')->name('site_externe.store')->middleware(['auth']);
    Route::post('/site-externe/update/{site_id}', 'update')->name('site_externe.update')->middleware(['auth']);
});

// Catégorie externes
Route::controller(CategorieexterneController::class)->group(function (){
    Route::get('/categorie-externes/{site_id?}', 'index')->name('categorie_externe.index')->middleware(['auth']);
    Route::get('/categorie-externe/add', 'create')->name('categorie_externe.add')->middleware(['auth']);
    Route::get('/categorie-externe/edit/{categorie_id}', 'edit')->name('categorie_externe.edit')->middleware(['auth']);
    Route::post('/categorie-externe/store', 'store')->name('categorie_externe.store')->middleware(['auth']);
    Route::post('/categorie-externe/update/{categorie_id}', 'update')->name('categorie_externe.update')->middleware(['auth']);
});



// Articles
Route::controller(ArticleController::class)->group(function (){
    Route::get('/articles', 'index')->name('article.index')->middleware(['auth']);
    Route::get('/article/add', 'create')->name('article.add')->middleware(['auth']);
    Route::get('/article/edit/{article_id}', 'edit')->name('article.edit')->middleware(['auth']);
    Route::get('/article/publier/{article_id}', 'publier')->name('article.publier')->middleware(['auth']);
    Route::post('/article/store', 'store')->name('article.store')->middleware(['auth']);
    Route::post('/article/update/{article_id}', 'update')->name('article.update')->middleware(['auth']);
});



// Scrapp
Route::controller(ScrapController::class)->group(function (){
    Route::get('/scrap', 'scrap')->name('scrap.index')->middleware(['auth']);
});

// Dashboard
// Route::controller(DashboardController::class)->group(function (){
//     Route::get('/', 'index')->name('welcome')->middleware(['auth']);
// });

require __DIR__.'/auth.php';

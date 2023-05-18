<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ScrapController;
use App\Http\Controllers\SiteexterneController;
use App\Http\Controllers\CategorieexterneController;
use App\Http\Controllers\CategorieinterneController;
use App\Http\Controllers\SiteinterneController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ClientController;

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

// Home
Route::controller(HomeController::class)->group(function (){
    Route::get('/', 'index')->name('home')->middleware(['auth']);
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

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

// Catégories externes
Route::controller(CategorieexterneController::class)->group(function (){
    Route::get('/categorie-externes/{site_id?}', 'index')->name('categorie_externe.index')->middleware(['auth']);
    Route::get('/categorie-externe/add', 'create')->name('categorie_externe.add')->middleware(['auth']);
    Route::get('/categorie-externe/edit/{categorie_id}', 'edit')->name('categorie_externe.edit')->middleware(['auth']);
    Route::post('/categorie-externe/store', 'store')->name('categorie_externe.store')->middleware(['auth']);
    Route::post('/categorie-externe/update/{categorie_id}', 'update')->name('categorie_externe.update')->middleware(['auth']);
});


// Sites internes
Route::controller(SiteinterneController::class)->group(function (){
    Route::get('/site-internes', 'index')->name('site_interne.index')->middleware(['auth']);
    Route::get('/site-interne/add', 'create')->name('site_interne.add')->middleware(['auth']);
    Route::get('/site-interne/edit/{site_id}', 'edit')->name('site_interne.edit')->middleware(['auth']);
    Route::post('/site-interne/alimenter/{site_id}', 'alimenter')->name('site_interne.alimenter')->middleware(['auth']);
    Route::get('/site-interne/join-site-externe/{site_id}', 'joinSiteexterne')->name('site_interne.join_site_externe')->middleware(['auth']);
    Route::post('/site-interne/store', 'store')->name('site_interne.store')->middleware(['auth']);
    Route::post('/site-interne/update/{site_id}', 'update')->name('site_interne.update')->middleware(['auth']);
});

// Catégories internes
Route::controller(CategorieinterneController::class)->group(function (){
    Route::get('/categorie-internes/{site_id}', 'index')->name('categorie_interne.index')->middleware(['auth']);
    Route::get('/categorie-interne/add', 'create')->name('categorie_interne.add')->middleware(['auth']);
    Route::get('/categorie-interne/edit/{categorie_id}/{pays?}', 'edit')->name('categorie_interne.edit')->middleware(['auth']);
    Route::post('/categorie-interne/store', 'store')->name('categorie_interne.store')->middleware(['auth']);
    Route::post('/categorie-interne/update/{categorie_id}', 'update')->name('categorie_interne.update')->middleware(['auth']);
});


// Articles
Route::controller(ArticleController::class)->group(function (){
    Route::get('/articles', 'index')->name('article.index')->middleware(['auth']);
    Route::get('/articles-externes', 'indexExterne')->name('article.index_externe')->middleware(['auth']);
    Route::get('/article/add', 'create')->name('article.add')->middleware(['auth']);
    Route::get('/article/edit/{article_id}', 'edit')->name('article.edit')->middleware(['auth']);
    Route::get('/article/edit-no-scrap/{article_id}', 'editNoScrap')->name('article.edit_no_scrap')->middleware(['auth']);
    Route::get('/article/edit-renomme/{article_id}', 'editRenomme')->name('article.edit_renomme')->middleware(['auth']);
    Route::get('/article/publier-article-externe/{article_id}', 'publierArticleExterne')->name('article.publier_article_externe')->middleware(['auth']);
    Route::get('/article/publier-article-interne/{article_id}', 'publierArticleInterne')->name('article.publier_article_interne')->middleware(['auth']);
    Route::post('/article/store', 'store')->name('article.store')->middleware(['auth']);
    Route::post('/article/update/{article_id}', 'update')->name('article.update')->middleware(['auth']);

    Route::get('/article/update-image/{article_id}', 'updateImage')->name('article.update_image')->middleware(['auth']);

    Route::get('/article/update-image/{article_id}', 'updateImage')->name('article.update_image')->middleware(['auth']);
    Route::get('/article/get-image/{image_id}', 'getImage')->name('article.get_image')->middleware(['auth']);
    Route::get('/article/destroy-image/{image_id}', 'destroyImage')->name('article.destroy_image')->middleware(['auth']);

    //  Route::post('/images-delete', 'BienController@destroyPhoto');
//   Route::get('/images-show', 'BienController@indexPhoto')->name('indextof');
//   Route::get('/photo-delete/{id}', 'BienController@deletePhoto')->name('photoDelete');
});




// Scrapp
Route::controller(ScrapController::class)->group(function (){
    Route::get('/scrap', 'scrap')->name('scrap.index')->middleware(['auth']);
    Route::get('/scrap/test-selecteur', 'indexSelecteur')->name('scrap.index_selecteur')->middleware(['auth']);
    Route::post('/scrap/tester-selecteur/{type_selecteur}', 'testerSelecteur')->name('scrap.tester_selecteur')->middleware(['auth']);
});


// Rôles 
Route::controller(RoleController::class)->group(function (){
    Route::get('/roles', 'index')->name('role.index')->middleware(['auth']);
    Route::post('/role/ajouter', 'store')->name('role.store')->middleware(['auth']);
    Route::post('/role/desarchiver/{roleId}', 'unarchive')->name('role.unarchive')->middleware(['auth']);
    Route::post('/role/modifier/{roleId}', 'update')->name('role.update')->middleware(['auth']);
    Route::put('/role/archiver/{roleId}', 'archive')->name('role.archive')->middleware(['auth']);
    Route::get('/role/permissions/{roleId}', 'permissions')->name('role.permissions')->middleware(['auth']);
    Route::post('/role/permissions/{roleId}', 'updatePermissions')->name('role.update_permissions')->middleware(['auth']);
});


// Utilisateur
Route::controller(UserController::class)->group(function (){
    Route::get('/utilisateurs', 'index')->name('utilisateur.index')->middleware(['auth']);
    Route::post('/utilisateur/ajouter', 'store')->name('utilisateur.store')->middleware(['auth']);
    Route::post('/utilisateur/modifier/{utilisateurId}', 'update')->name('utilisateur.update')->middleware(['auth']);
    Route::post('/utilisateur/desarchiver/{utilisateurId}', 'unarchive')->name('utilisateur.unarchive')->middleware(['auth']);
    Route::post('/utilisateur/archiver/{utilisateurId}', 'archive')->name('utilisateur.archive')->middleware(['auth']);
});

// Clients
Route::controller(ClientController::class)->group(function (){
    Route::get('/clients', 'index')->name('client.index')->middleware(['auth']);
    Route::post('/client/ajouter', 'store')->name('client.store')->middleware(['auth']);
    Route::post('/client/modifier/{clientId}', 'update')->name('client.update')->middleware(['auth']);
    Route::post('/client/desarchiver/{clientId}', 'unarchive')->name('client.unarchive')->middleware(['auth']);
    Route::post('/client/archiver/{clientId}', 'archive')->name('client.archive')->middleware(['auth']);
});


// Permissions
Route::controller(PermissionController::class)->group(function (){
    Route::get('/permissions', 'index')->name('permission.index')->middleware(['auth']);
    Route::post('/permission/ajouter', 'store')->name('permission.store')->middleware(['auth']);
    Route::post('/permission/desarchiver/{roleId}', 'unarchive')->name('permission.unarchive')->middleware(['auth']);
    Route::post('/permission/modifier/{permission_id}', 'update')->name('permission.update')->middleware(['auth']);
    Route::post('/permission/modifier', 'updateRolePermission')->name('permission_role.update')->middleware(['auth']);
    Route::put('/permission/archiver/{roleId}', 'archive')->name('permission.archive')->middleware(['auth']);
});

require __DIR__.'/auth.php';

<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

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

Auth::routes();

Route::get('login', [LoginController::class, 'index']);
Route::post('login', [LoginController::class, 'login'])->name('login');

// Route::get('force-store-role', [RegisterController::class, 'forceStoreRole']);
// Route::get('force-store-user', [RegisterController::class, 'forceStoreUser']);
// Route::get('force-store-menu', [RegisterController::class, 'forceStoreMenu']);
// Route::get('force-store-menu-auth', [RegisterController::class, 'forceStoreMenuAuth']);

Route::group(['middleware' => ['web']], function () {
  Route::get('', 'HomeController@index');
  Route::get('home', 'HomeController@index')->name('home');
  Route::post('logout', [LoginController::class, 'logout'])->name('logout');

  Route::middleware('check_user_role')->group(function () { // config ada di kernel app/http/kernel
    // Route Menu
    Route::get('menu-destroy/{id}', 'MenuController@destroy')->name('menu.destroy');
    Route::get('menu/sort', 'MenuController@sort')->name('menu.sort');
    Route::resource("menu", 'MenuController');

    // Route Role
    Route::get('role-destroy/{id}', 'RoleController@destroy')->name('role.destroy');
    Route::get('role-change-status/{id}', 'RoleController@changeStatus')->name('role.change-status');
    Route::post('role/get-role-by-select2', 'RoleController@getRoleBySelect2')->name('getRoleBySelect2');
    Route::get('role/menu-auth/{id}', 'MenuAuthController@index')->name('role.menu-auth');
    Route::post('role/menu-auth/store', 'MenuAuthController@store')->name('role.menu-auth.store');
    Route::resource("role", 'RoleController');

    // Route User
    Route::get('user-destroy/{id}', 'UserController@destroy')->name('user.destroy');
    Route::get('user-reset/{id}', 'UserController@resetPass')->name('user.reset');
    Route::get('user-change-status/{id}', 'UserController@changeStatus')->name('user.change-status');
    Route::post('user/get-user-by-select2', 'UserController@getUserBySelect2')->name('getUserBySelect2');
    Route::resource("user", 'UserController');

    // Route Country
    Route::get('country-destroy/{id}', 'CountryController@destroy')->name('country.destroy');
    Route::post('country/get-country-by-select2', 'CountryController@getCountryBySelect2')->name('getCountryBySelect2');
    Route::resource("country", 'CountryController');

    // Route Pharma
    Route::get('pharma-destroy/{id}', 'PharmaController@destroy')->name('pharma.destroy');
    Route::post('pharma/get-pharma-by-select2', 'PharmaController@getPharmaBySelect2')->name('getPharmaBySelect2');
    Route::resource("pharma", 'PharmaController');

    // Route Drug Type
    Route::get('drug-type-destroy/{id}', 'DrugTypeController@destroy')->name('drug-type.destroy');
    Route::post('drug-type/get-drug-type-by-select2', 'DrugTypeController@getDrugTypeBySelect2')->name('getDrugTypeBySelect2');
    Route::resource("drug-type", 'DrugTypeController');

    // Route Drug Category
    Route::get('drug-category-destroy/{id}', 'DrugCategoryController@destroy')->name('drug-category.destroy');
    Route::post('drug-category/get-drug-category-by-select2', 'DrugCategoryController@getDrugCategoryBySelect2')->name('getDrugCategoryBySelect2');
    Route::resource("drug-category", 'DrugCategoryController');

    // Route Drug
    Route::get('drug-destroy/{id}', 'DrugController@destroy')->name('drug.destroy');
    Route::get('drug-change-status/{id}', 'DrugController@changeStatus')->name('drug.change-status');
    Route::post('drug/get-drug-by-select2', 'DrugController@getDrugBySelect2')->name('getDrugBySelect2');
    Route::post('drug/get-drug-qty', 'DrugController@getDrugQty')->name('getDrugQty');
    Route::post('drug/get-drug-qty-n-expired', 'DrugController@getDrugQtyAndExpired')->name('getDrugQtyAndExpired');
    Route::resource("drug", 'DrugController');

    // Route Storage Logs
    Route::get('storage-log-destroy/{id}', 'StorageLogController@destroy')->name('storage-log.destroy');
    Route::get('storage-log-cancel/{id}', 'StorageLogController@cancel')->name('storage-log.cancel');
    Route::resource("storage-log", 'StorageLogController');

    // Route Report
    Route::get('monthly-report', 'ReportController@monthlyReport')->name('report.monthly');
    Route::get('yearly-report', 'ReportController@yearlyReport')->name('report.yearly');
    Route::resource("report", 'ReportController');
  });
});

Route::group(['middleware' => ['public']], function () {
  //
});

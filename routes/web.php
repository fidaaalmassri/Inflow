<?php

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

 

Route::post('/lang' , 'LangController\LangController@index')->middleware('lang')->name('langGange');
Route::get('/change/en' , 'LangController\LangController@changeToEn')->middleware('lang')->name('langGange');
Route::get('/change/ar' , 'LangController\LangController@changeToAr')->middleware('lang')->name('langGange');
Auth::routes();
Route::get('/', function () {
    return redirect('/login');
});
Route::get('/home', 'HomeController@index')->name('home');

Route::namespace('Company')->prefix('/company')->group(function (){
    Route::get('/signup', 'CompanyController@index')->name('company-signup');

    Route::post('/addCompany', 'CompanyController@store')->name('company.store');

    Route::get('profile/{id}', 'CompanyController@show_profile')->name('profile');
    Route::get('influencers', 'CompanyController@all_influencers')->name('all_influencers');

    

});

Route::get('logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');




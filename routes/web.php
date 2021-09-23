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
Route::get('/company-signup', 'Company\CompanyController@index')->name('company-signup');
Route::get('/home', 'HomeController@index')->name('home');
// Route::get('/getLoginUrl', 'HomeController@getLoginUrl')->name('getLoginUrl');
// Route::get('/login/google/callback', 'HomeController@googleCallback')->name('googleCallback');
// Route::get('/cadWithAuth', 'HomeController@cadWithAuth')->name('cadWithAuth');
// Route::get('/social-auth/{provider}', 'Auth\SocialController@redirectToProvider')->name('auth.social');

// Route::get('/social-auth/{provider}/callback', 'Auth\SocialController@handleProviderCallback')->name('auth.social.callback');
Route::get('/cadWithAuth', function () {
    $query = http_build_query([
        'client_id' => '197179214595-1hicdi5vrnrq6m9pv0g297k36bjnctqe.apps.googleusercontent.com', 
        'access_type'=>'offline',
        'include_granted_scopes' => 'true',
        'state'=>'state_parameter_passthrough_value',
        'redirect_uri' => 'http://127.0.0.1:8000/login/google/callback',
        'response_type' => 'code',
        'scope' => 'https://www.googleapis.com/auth/youtube.readonly'
    ]);
    // $auth_url = $query->createAuthUrl();
 
    // header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
    // return redirect($auth_url);

    return redirect('https://accounts.google.com/o/oauth2/auth?'.$query);
});
Route::get('/getLoginUrl', 'HomeController@getLoginUrl');


Route::get('/login/google/callback', 'HomeController@youtubeCallback');
Route::get('/todos', function () {
    $response = (new GuzzleHttp\Client)->get('http://127.0.0.1:8000/todos', [
        'headers' => [
            'Authorization' => 'Bearer '.session()->get('token.access_token')
        ]
    ]);

    return json_decode((string) $response->getBody(), true);
});
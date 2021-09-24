<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use GuzzleHttp\Client;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function redirectToInstagramProvider()
{
    $appId = config('services.instagram.client_id');
    $redirectUri = urlencode(config('services.instagram.redirect'));
    return redirect()->to("https://api.instagram.com/oauth/authorize?app_id=230589115714459&redirect_uri=".urlencode("https://localhost/Inflow/public/callback")."&scope=user_profile,user_media&response_type=code");
}

public function instagramProviderCallback(Request $request)
{
    $code = $request->code;
    if (empty($code)) return redirect()->route('home')->with('error', 'Failed to login with Instagram.');

    $appId ='230589115714459';     //config('services.instagram.client_id');
    $secret = '95b786109e132a7c01883593b07a69b7' ;//config('services.instagram.client_secret');
    $redirectUri = 'https://localhost/Inflow/public/callback' ;//config('services.instagram.redirect');

    $client = new Client();

    // Get access token
    $response = $client->request('POST', 'https://api.instagram.com/oauth/access_token', [
        'form_params' => [
            'app_id' => $appId,
            'app_secret' => $secret,
            'grant_type' => 'authorization_code',
            'redirect_uri' => $redirectUri,
            'code' => $code,
        ]
    ]);
// dd($response);


    if ($response->getStatusCode() != 200) {
        return redirect()->route('home')->with('error', 'Unauthorized login to Instagram.');
    }

    $content = $response->getBody()->getContents();
    $content = json_decode($content);
// dd($content);
    $accessToken = $content->access_token;
    $userId = $content->user_id;

    // Get user info
    $response = $client->request('GET', "https://graph.instagram.com/me?fields=id,username,account_type&access_token={$accessToken}");

    $content = $response->getBody()->getContents();
    $oAuth = json_decode($content);
dd($oAuth);
    // Get instagram user name 
    $username = $oAuth->username;

    // do your code here
}
}

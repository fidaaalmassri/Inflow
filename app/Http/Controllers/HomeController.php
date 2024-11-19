<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use  alchemyguy\YoutubeLaravelApi\AuthenticateService;
use alchemyguy\YoutubeLaravelApi\ChannelService;
use alchemyguy\YoutubeLaravelApi\VideoService;
 use Analytics;
use Spatie\Analytics\Period;
use GuzzleHttp\Client;
use Socialite;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
     
       
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
      // return view('layouts.dashboard');
        if(auth::user()->role_id == 1){

            
     return redirect(route('profile_influencer',['id'=>auth::user()->id]));

        }else{
        return redirect(route('profile',['id'=>auth::user()->id]));

        }
    }
 
    public  function youtubeCallback (Request $request) {
        
        $authObject  = new AuthenticateService;
        
        // // # Replace the identifier with a unqiue identifier for account or channel
        // $authUrl = $authObject->getLoginUrl('sharda.nainggolan28@gmail.com','UCY47kwwJXNRYcen0zGORKsA'); 
        // // dd($authUrl);
        $code = $request->get('code');
        $identifier = $request->get('state');

        // dd($code);

        if($code != null) {
            $request->session()->forget('youtube_code');
            // $_SESSION['youtube_code'] = $code;
            session(['youtube_code' => $code]);
                    $code = $request->session()->get('youtube_code');

             $authObject  = new AuthenticateService;
            $authResponse = $authObject->authChannelWithCode($code);
// $authResponse['token']  
// $authResponse['channel_details']
// $authResponse['live_streaming_status']
            print_r($authResponse);
            // dd($authResponse);
        }
        // $code = $request->get('code');
        // $authObject  = new AuthenticateService;
        // $request->session()->forget('youtube_code');
        // session(['youtube_code' => $code]);
        $code = $request->session()->get('youtube_code');
        // $authResponse = $authObject->authChannelWithCode('4/0AX4XfWgaz73LQAuwOBwosHNPBJJfHf7Kj7Yvtnh3e0SAK9IoDAwVG04Qn8dml_XSWK3hzg');
        // $authResponse = $authObject->authChannelWithCode($code);
        // dd($authResponse ) ;
        dd($code ) ;

    }
    
    
            
}
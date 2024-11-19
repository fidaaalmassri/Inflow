<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use GuzzleHttp\Client;
use Socialite;
use App\User;
use App\Influence;
use Illuminate\Support\Facades\Auth;


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
                    $this->middleware('guest' )->except( 'logout' );
                }
            
            
             
            public function redirectToSnapchatProvider()
            
            {
             $appId = "260e83ae-bb64-44cf-925f-d259692493c0";
            $secret = "-Ya0tvL95rrIEye2O3bd8X9xYK5aNcDiZnmwwwZ5OfU";
            $redirectUri = "https://localhost/Inflow/public/snapchat/callback";
            // $appId = config('services.snapchat.client_id');
            // $redirectUri = urlencode(config('services.snapchat.redirect'));
            // return redirect()->to("https://accounts.snapchat.com/accounts/oauth2/auth?app_id=260e83ae-bb64-44cf-925f-d259692493c0&redirect_uri=".urlencode("https://localhost/Inflow/public/callback")."&scope=user_profile,user_media&response_type=code");
            $state = md5(uniqid(rand(), true));
            $additionalProviderConfig = ['scopeList' => array("https://auth.snapchat.com/oauth2/api/user.display_name",
            "https://auth.snapchat.com/oauth2/api/user.bitmoji.avatar",
            "https://auth.snapchat.com/oauth2/api/user.external_id"),    
                    'response_type' => 'code',
                    'state'=>$state,
            ];
            $scopeList= array("https://auth.snapchat.com/oauth2/api/user.display_name",
                               "https://auth.snapchat.com/oauth2/api/user.bitmoji.avatar",
                               "https://auth.snapchat.com/oauth2/api/user.external_id"
            );
            
            $scopes = [
                'https://auth.snapchat.com/oauth2/api/user.display_name',
                'https://auth.snapchat.com/oauth2/api/user.bitmoji.avatar',
                'https://auth.snapchat.com/oauth2/api/user.external_id'
            ];
            
            $state = md5(uniqid(rand(), true));
            $code_verifier = "AdleUo9ZVcn0J7HkXOdzeqN6pWrW36K3JgVRwMW8BBQazEPV3kFnHyWIZi2jt9gA";
            $code_challenge = hash("sha256",$code_verifier);
            
            $query_params = [
                'response_type' => 'code',
                'redirect_uri' => config('services.snapchat.redirect'),
                'scope' => implode(' ',$scopes),
                'client_id' =>  config('services.snapchat.client_id'),
                'state' => $state,
                'code_challenge' => $code_challenge,
                'code_challenge_method' => 'S256'
            ];
            
            // Return full URL
            // return "https://accounts.snapchat.com/accounts/oauth2/auth?" . http_build_query($query_params);
            
            // return redirect()->to("https://accounts.snapchat.com/accounts/oauth2/auth?app_id=230589115714459&redirect_uri=".urlencode("https://localhost/Inflow/public/callback")."&scope=implode(' ',$scopes)&response_type=code");
            // return redirect()->to("https://accounts.snapchat.com/accounts/oauth2/auth?". http_build_query($query_params));
            
            $config = new \SocialiteProviders\Manager\Config($appId, $secret, $redirectUri);
            return Socialite::with('snapchat')->setConfig($config)->redirect();
            // $client = new Client();
            // // Get access token
            // $response = $client->request('GET', 'https://accounts.snapchat.com/accounts/oauth2/auth', [
            //     'form_params' => [
            //         'client_id' => $appId,
            //         'client_secret' => $secret,
            //          'redirectUri' => $redirectUri,
            //          'scopeList'=> ['https://auth.snapchat.com/oauth2/api/user.display_name',
            //          'https://auth.snapchat.com/oauth2/api/user.bitmoji.avatar',
            //          'https://auth.snapchat.com/oauth2/api/user.external_id'
            //     ],
            //              'response_type' =>'code',
            
            
            //     ]
            // ]);
            
                    // $influence_info = new Influence();
                    // $influence_info->user_id = $user_influencer->id;
                    // $influence_info->save();
                    // $user=User::find($user_influencer->id);
                    Auth::login($user_influencer);
            
            }
            public function snapchatProviderCallback(Request $request)
            {
                
            
                $code = $request->code;
                $state= $request->state;
                if (empty($code)) return redirect()->route('home')->with('error', 'Failed to login with Snapchat.');
                $url="https://accounts.snapchat.com/accounts/oauth2/token";
                $appId = "260e83ae-bb64-44cf-925f-d259692493c0";
                $secret = "-Ya0tvL95rrIEye2O3bd8X9xYK5aNcDiZnmwwwZ5OfU";
                $redirectUri = "https://localhost/Inflow/public/snapchat/callback";
                $client = new Client();
                 
            $header = base64_encode($appId.":".$secret);
            $payloaded_url=$url."?client_id=".$appId."&client_secret=".$secret."&grant_type=authorization_code&redirect_uri=".$redirectUri."&code=".$code;//."&code_verifier=".$code_verifier; 
                
            
            $ch = curl_init($payloaded_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, 1);
            
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type' => 'application/json',
                 'Authorization'=> 'Basic '.$header
            ));
            
            
            // execute!
            $res = curl_exec($ch);
            
            // close the connection, release resources used
            curl_close($ch);
            
            $response= json_decode($res);
            
            $access_token=$response->access_token;
            // https://adsapi.snapchat.com/v1/me
            $res = $client->request('GET', 'https://kit.snapchat.com/v1/me?query={me{externalId displayName bitmoji{avatar id}}}', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer '.$access_token,
                ],
                
            ]);
            /*
            ➜  ~  curl -H "X-Api-Token: cddb6686e7b408dc7292ea92bd833243"
             https://snapchat-example-api.herokuapp.com/api/v1/users/friends                                                      
            
            */
            
            $content = $res->getBody()->getContents();
            $oAuth = json_decode($content);
            dd($oAuth->data );
            
               // Get Snapchat user name 
            // $username = $oAuth->data->me->displayName;
            return $username;
            
            
            }
            
            public function check_username(){
            
                    # This header is specific for checking the username
                
            
                     $appId = "260e83ae-bb64-44cf-925f-d259692493c0";
                    $secret = "-Ya0tvL95rrIEye2O3bd8X9xYK5aNcDiZnmwwwZ5OfU";
                    $redirectUri = "https://localhost/Inflow/public/snapchat/callback";
                    $res = $client->request('GET', 'https://accounts.snapchat.com/accounts/get_username_suggestions?requested_username={}&xsrf_token=PlEcin8s5H600toD4Swngg', [
                        'headers' => [
                           "User-Agent"=>  "Mozilla/5.0 (Macintosh; Intel Mac OS X 10.14; rv:66.0) Gecko/20100101 Firefox/66.0",
                            "Accept"=> "*/*",
                            "Accept-Language"=> "en-US,en;q=0.5",
                            "Referer"=> "https://accounts.snapchat.com/",
                            "Cookie"=> "xsrf_token=PlEcin8s5H600toD4Swngg; sc-cookies-accepted=true; web_client_id=260e83ae-bb64-44cf-925f-d259692493c0; oauth_client_id=c2Nhbg==",
                            "Connection"=> "keep-alive",
                            "Content-Type"=> "application/x-www-form-urlencoded; charset=utf-8",
                
                        ],
                        
                    ]);
                    // r = requests.post(check_username_url.format(self.username), headers=headers)
                    
                    // data = r.json()
            
                    // status = data.get("reference").get("status_code")
                    // suggestions = data.get("reference").get("suggestions")
            
                    // if len(suggestions):
                    //     self.username_suggestions = suggestions
                    
            
                    // if status == "TAKEN" or "TOO_LONG" or "INVALID_CHAR":
                    //     error_message = data.get("reference").get("error_message")
            
                    //     return error_message
            
                    // return "Username available"
                    }
            public function redirectToInstagramProvider(){
                $appId = config( 'services.instagram.client_id' );
                $redirectUri = urlencode( config( 'services.instagram.redirect' ) );
                return redirect()->to('https://api.instagram.com/oauth/authorize/?client_id=567445094511374&redirect_uri=' . urlencode('https://inflowdashboard.inflow-sa.com/public/callback') . '&response_type=code&scope=email,public_profile');
                return redirect()->to( 'https://api.instagram.com/oauth/authorize?app_id=567445094511374&redirect_uri='.urlencode( 'https://inflowdashboard.inflow-sa.com/public/callback' ).'&scope=" " &response_type=code' );
            }
            
            public function instagramProviderCallback( Request $request ){
                $code = $request->code;
                if ( empty( $code ) ) return redirect()->route( 'home' )->with( 'error', 'Failed to login with Instagram.' );
            
                $appId = '377656684087135';
                //'230589115714459';
                //config( 'services.instagram.client_id' );
                $secret = '9e42a5411c3afba51d6ef229b5d4994d';
                //'95b786109e132a7c01883593b07a69b7' ;
                //config( 'services.instagram.client_secret' );
                $redirectUri = 'https://inflowdashboard.inflow-sa.com/public/callback' ;
                //config( 'services.instagram.redirect' );
            
                $client = new Client();
            
                // Get access token
                $response = $client->request( 'POST', 'https://api.instagram.com/oauth/access_token', [
                    'form_params' => [
                        'app_id' => $appId,
                        'app_secret' => $secret,
                        'grant_type' => 'authorization_code',
                        'redirect_uri' => $redirectUri,
                        'code' => $code,
                    ]
                ] );
                // dd( $response );
            
                if ( $response->getStatusCode() != 200 ) {
                    return redirect()->route( 'home' )->with( 'error', 'Unauthorized login to Instagram.' );
                }
            
                $content = $response->getBody()->getContents();
                $content = json_decode( $content );
                //  dd( $content );
                $accessToken = $content->access_token;
                $userId = $content->user_id;
            
                // Get user info
                $response = $client->request( 'GET', "https://graph.instagram.com/me?fields=id,username,account_type&access_token={$accessToken}" );
            
                $content = $response->getBody()->getContents();
                $oAuth = json_decode( $content );
                // dd( $oAuth );
                // Get instagram user name
                $username = $oAuth->username;
                $user_influencer = new User();
                $user_influencer->name = $username;
                $user_influencer->email = $username;
            
                $user_influencer->role_id = 1;
                // role_id = 1 => influencer account
                $user_influencer->save();
            
            
                // $user=User::find($user_influencer->id);
                Auth::login($user_influencer);
            
                $follwers = $this->getDetails( 'https://instagram.com/'.$username );
            
                // return redirect(route('dash'));
                     return redirect(route('profile_influencer',['id'=>$user_influencer->id]));

             
                // $data = $res->getBody()->getContents();
                // $oAuthd = json_decode( $data );
                // dd( $res );
            
                // do your code here
            }
            
             
            function getDetails( $pageUrl ) {
                $url = $pageUrl;
                $ch = curl_init();
                curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
                curl_setopt( $ch, CURLOPT_HEADER, false );
                curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
                curl_setopt( $ch, CURLOPT_URL, $url );
                curl_setopt( $ch, CURLOPT_REFERER, $url );
                curl_setopt( $ch, CURLOPT_RETURNTRANSFER, TRUE );
                $result = curl_exec( $ch );
                curl_close( $ch );
                // dd( $result );
                $output;
                $metaPos = strpos( $result, '<meta content=' );
                if ( $metaPos != false )
            {
                    $meta = substr( $result, $metaPos, 70 );
            
                    //meghdare followers
                    $followerPos = strpos( $meta, 'Followers' );
                    $followers = substr( $meta, 15, $followerPos-15 );
                    $output[0] = $followers;
            
                    //meghdare followings
                    // $commaPos = strpos( $meta, ',' );
                    $followingPos = strpos( $meta, 'Following' );
                    $followings = substr( $meta, $followerPos+10, $followingPos - ( $followerPos+10 ) );
                    $output[1] = $followings;
            
                    //meghdare posts
                    $seccondCommaPos = $followingPos + 10;
                    $postsPos = strpos( $meta, 'Post' );
                    $posts = substr( $meta, $seccondCommaPos, $postsPos - $seccondCommaPos );
                    $output[2] = $posts;
            
                    //   //image finder
                    //     $imgPos = strpos( $result, 'og:image' );
                    //     $image = substr( $result, $imgPos+19, 200 );
                    //     $endimgPos = strpos( $image, '/>' );
                    //     $finalImagePos = substr( $result, $imgPos+19, $endimgPos-2 );
                    //     $output[3] = $finalImagePos;
            
                    return $output;
                } else {
                    return null;
                }
            }
            


            public  function cadWithAuth () {
        
                // return Socialite::driver('youtube')->redirect();
                // return Socialite::with('youtube')->redirect();
        /*
         'https://www.googleapis.com/auth/plus.me',
                    'https://www.googleapis.com/auth/plus.profile.emails.read',
                    'https://www.googleapis.com/auth/gmail.readonly',
        */
                // $scopes = [
                   
                //     'https://www.googleapis.com/auth/youtube.readonly',
                // ];
                // $parameters = ['access_type' => 'offline'];
         /*       // return Socialite::driver('google')->scopes($scopes)->with($parameters)->redirect();
                GOOGLE_CLIENT_ID=197179214595-1hicdi5vrnrq6m9pv0g297k36bjnctqe.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=2urMSV6IHY8N5ktmHwhbVupf
GOOGLE_URL=https://inflowdashboard.inflow-sa.com/login/google/callback
GOOGLE_API_KEY=197179214595-1hicdi5vrnrq6m9pv0g297k36bjnctqe.apps.googleusercontent.com
*/
                $query = http_build_query([
                    'client_id' => '197179214595-1hicdi5vrnrq6m9pv0g297k36bjnctqe.apps.googleusercontent.com', 
                    'access_type'=>'offline',
                    'include_granted_scopes' => 'true',
                    'state'=>'state_parameter_passthrough_value',
                    'redirect_uri' => 'https://inflowdashboard.inflow-sa.com/login/google/callback',
                    'response_type' => 'code',
                    'scope' => 'https://www.googleapis.com/auth/youtube.readonly'
                ]);
                return redirect('https://accounts.google.com/o/oauth2/auth?'.$query);
        
            }

            public  function youtubeCallback (Request $request) {
                
    $code = $request->code;
    $authObject  = new AuthenticateService;
    $authResponse = $authObject->authChannelWithCode($code);
       return $authResponse  ;
      /*
                $scopes = [
                   
                    // 'https://www.googleapis.com/auth/youtube.readonly',
                    'https://www.googleapis.com/youtube/v3/channels?part=snippet&mine=true',
        
                ];
                $parameters = ['access_type' => 'offline'];
                // $user =  Socialite::driver('google')->scopes($scopes)->with($parameters)->user(); 
                // ->with()->with(["prompt" => "select_account", 'response_type' => 'code',)   
                $user = Socialite::driver('google')->stateless()->scopes($scopes)->user();
    
                    $accessToken = $user->token;
                    $channelid = $user->id;
                    // $client = new Client();        
                   $api_key='197179214595-1hicdi5vrnrq6m9pv0g297k36bjnctqe.apps.googleusercontent.com';


                //    $authObject  = new AuthenticateService;
                   $code = $request->get('code');
                   $identifier = $request->get('state');
                   if($code != null) {
                       $request->session()->forget('youtube_code');
                       session(['youtube_code' => $code]);
                               $code = $request->session()->get('youtube_code');
           
                        $authObject  = new AuthenticateService;
                       $authResponse = $authObject->authChannelWithCode($code);
           // $authResponse['token']  
           // $authResponse['channel_details']
           // $authResponse['live_streaming_status']
                        // dd($authResponse);
                   }
                  
                   $code = $request->session()->get('youtube_code');    
                    dd($code ) ;

              
                   // $response = $client->request('GET', ' https://youtube.googleapis.com/youtube/v3/channels?part=statistics&id='.$channelid.'&key=197179214595-1hicdi5vrnrq6m9pv0g297k36bjnctqe.apps.googleusercontent.com', [
                    //     'headers' => [
                    //         'Content-Type' => 'application/json',
                    //         'Authorization' => 'Bearer '.$accessToken,
                    //     ],
                        
                    // ]);
        
                    // $api_response = file_get_contents('https://www.googleapis.com/youtube/v3/channels?part=statistics&id='.$channelid.'&fields=items/statistics/subscriberCount&key='.$api_key);
                    // $response = json_decode($api_response, true);
                    //   dd($response);
                    // $api_url = 'https://content.googleapis.com/youtube/v3/channels';
        
                    //     $query = [
                    //         'id' => $channelid, // Channel ID.
                    //         'key' => '197179214595-1hicdi5vrnrq6m9pv0g297k36bjnctqe.apps.googleusercontent.com', // Your API Key.
                    //         'part' => 'snippet,contentDetails,statistics',
                    //     ];
        
                    //     $request_url = sprintf(
                    //         '%s?%s',
                    //         $api_url,
                    //         http_build_query( $query )
                    //     );
        
        
                    
                    // $response = $client->request('GET', 'https://www.googleapis.com/youtube/v3/channels', [
                    //     'query' => ['snippet,contentDetails,statistics', $queryParams]
                    // ]);
                    
                // $response = $service->channels->listChannels('snippet,contentDetails,statistics', $queryParams);
        
                // $user = Socialite::driver('youtube')->stateless()->user();
                 //    return $authResponse  
                //  $socialite = Socialite::driver('youtube');
        
                //  $code      = $request->get('code');
                //  $response  = $user->getAccessTokenResponse($code);
                 
                                //  dd($response);
                // $code = $request->get('code');
                // $authObject  = new AuthenticateService;
                // $request->session()->forget('youtube_code');
                // session(['youtube_code' => $code]);
                // $code = $request->session()->get('youtube_code');
                // // dd($code);
                // // $authResponse = $authObject->authChannelWithCode('4/0AX4XfWgaz73LQAuwOBwosHNPBJJfHf7Kj7Yvtnh3e0SAK9IoDAwVG04Qn8dml_XSWK3hzg');
                // $authResponse = $authObject->authChannelWithCode($code);
                // dd($authResponse ) ;
        */
            }
            }
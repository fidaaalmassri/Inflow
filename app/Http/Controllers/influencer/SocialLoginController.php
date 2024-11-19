<?php

namespace App\Http\Controllers\influencer;

use App\Http\Controllers\Controller;


use Illuminate\Http\Request;
use alchemyguy\YoutubeLaravelApi\AuthenticateService;	
use alchemyguy\YoutubeLaravelApi\ChannelService;
use alchemyguy\YoutubeLaravelApi\VideoService;
use Validator;

use Config;
use App\User;

//use Session;
use Cookie;



use Illuminate\Support\Facades\Auth;

use App\Classes\hybridauth\src\Exception\Exception;
use App\Classes\hybridauth\src\Hybridauth;
use App\Classes\hybridauth\src\HttpClient;
use App\Classes\hybridauth\src\Storage\Session;


class SocialLoginController extends Controller
{
    
      public function socialCallback($pv=''){
          // dd($pv);
        //dd('https://teachmearabic.org/'.Config::get('lang').'/social-callback');
        $config = [
          /**
           * Set the Authorization callback URL to https://path/to/hybridauth/examples/example_06/callback.php.
           * Understandably, you need to replace 'path/to/hybridauth' with the real path to this script.
           */
          'callback' => 'https://inflowdashboard.inflow-sa.com/influencer/social-callback',
          'providers' => [
            'Twitter' => [
              'enabled' => true,
              'keys' => [
                'key' => 'otjhjb9PyyNiZqGmriPIzZvzE',
                'secret' => 'lyZ21PZxE6LGARmSB0X9MGPhccWF6IYrxuXWCAxjUpFEpyTCT0',
              ],
            ],
            'Google' => [
              'enabled' => true,
              'keys' => [
                'id' => '197179214595-1hicdi5vrnrq6m9pv0g297k36bjnctqe.apps.googleusercontent.com',
                'secret' => '2urMSV6IHY8N5ktmHwhbVupf',
              ],
              
            ],
            'Facebook' => [
              'enabled' => true,
              'keys' => [
                       'id' => '1026545301156426',
                'secret' => 'f1ab553d5dadefbba6cbcd5f0b89a417',
              ],
            ],
            
              'Instagram' => [
              'enabled' => true,
              'keys' => [
                'id' => '377656684087135',
                'secret' => '9e42a5411c3afba51d6ef229b5d4994d',
              ],
                 
            ],
         
          ],
        ];
        
        try {
            /**
             * Feed configuration array to Hybridauth.
             */
            $hybridauth = new Hybridauth($config);
        
            /**
             * Initialize session storage.
             */
            $storage = new Session();
        
            /**
             * Hold information about provider when user clicks on Sign In.
             */
        	$getProvider='';//'Facebook'
            if ($pv != '') {
                $getProvider=$pv;//'Facebook'
                $storage->set('provider', $pv);
            }
        
            /**
             * When provider exists in the storage, try to authenticate user and clear storage.
             *
             * When invoked, `authenticate()` will redirect users to provider login page where they
             * will be asked to grant access to your application. If they do, provider will redirect
             * the users back to Authorization callback URL (i.e., this script).
             */
            if ($provider = $storage->get('provider')) {
            
                $hybridauth->authenticate($provider);
                $storage->set('provider', null);		
            }
        
            /**
             * This will erase the current user authentication data from session, and any further
             * attempt to communicate with provider.
             */
            if (isset($_GET['logout'])) {
             
                $adapter = $hybridauth->getAdapter($_GET['logout']);
                $adapter->disconnect();
            }
        	
        
            /**
             * Redirects user to home page (i.e., index.php in our case)
             */
        	 $adapters = $hybridauth->getConnectedAdapters();
        // 	 dd('salam');
        // 	 print_r($adapters->getUserProfile());exit;
        	 //print_r($adapters['Google']->getUserProfile());exit;lo
        	 $logedin=false;
        // 	 dd($adapters);
        // 	 exit;
        	 if ($adapters) : 
            	foreach ($adapters as $name => $adapter) :
                    
            	    $email=$adapter->getUserProfile()->email;
            	    $full_name=$adapter->getUserProfile()->displayName;
            	    //dd($adapter->getUserProfile());
            	    if($email=='')  $email=$adapter->getUserProfile()->identifier;
            	    if($full_name=='')  $full_name=$email;
            	    
            	        $user_influencer = new User();
                        $user_influencer->name = $full_name;
                        $user_influencer->email = $email;
                        $user_influencer->password = $adapter->getUserProfile()->identifier.'@'.$name;
                        $user_influencer->role_id = 1;
                        // role_id = 1 => influencer account
                        $user_influencer->save();
            	    
            	     Auth::login( $user_influencer );
            	     

                     return redirect(route('profile_influencer',['id'=>$user_influencer->id]));

        // 			$data = [
        //         		'email'    => $name."-_-".$email,
        //         		'password' => $adapter->getUserProfile()->identifier.'@'.$name,
        //         		'first_name' => $adapter->getUserProfile()->firstName,
        //         		'last_name' => $adapter->getUserProfile()->lastName, 
        //         		'mobile_no' => '',
        //         		'permissions' =>  [],
        //         		'username' => $name."-_-".$email,
        //         		'countryid' => 0,
        //         		'description' => $full_name,
        //         		'facebook' => '',
        //         		'twitter' => '',
        //         		'website' => '',
        //         		'image' => '',
        //         		'sub_permissions'=> '',
        //         		'dep' => 0,
        //         		'full_name' => $full_name,
        //         	];
                	
                	
        //           dd($data);
                   
                //   $data2=[
                //             "login"=> $name."-_-".$email,
                //             "password"=>$adapter->getUserProfile()->identifier.'@'.$name
                //          ];
                  
                endforeach;				
         	 endif;
        	 
        // 	 return redirect(route('login'));
        } catch (Exception $e) {
            // dd('salam');
            return redirect(route('login'));
            echo $e->getMessage();
        }
        return redirect(route('login'));
    }
    
    public function socialCallback1($provider=''){
        
        $config = [
          /**
           * Set the Authorization callback URL to https://path/to/hybridauth/examples/example_06/callback.php.
           * Understandably, you need to replace 'path/to/hybridauth' with the real path to this script.
           */
          'callback' => 'https://inflowdashboard.inflow-sa.com/influencer/social-callback',
          'providers' => [
            'Twitter' => [
              'enabled' => true,
              'keys' => [
                'key' => 'oWgRFghhbJfUzfjbVHhAS4ElV',
                'secret' => 'aGp3MiRcdRQ7SyDId0kMHfkonorlm5iiSSRlubkb5XKFabmUEt',
              ],
            ],
            'Google' => [
              'enabled' => true,
              'keys' => [
                'id' => '875341763011-jeaos4mmrjhhvjl16gdfhflj9i1be23q.apps.googleusercontent.com',
                'secret' => 'DzGYwiSmvh5LcrXKyo5n3-Ws',
              ],
            ],
            'Facebook' => [
              'enabled' => true,
              'keys' => [
                'id' => '1026545301156426',
                'secret' => 'f1ab553d5dadefbba6cbcd5f0b89a417',
              ],
            ],
            
             'Instagram' => [
              'enabled' => true,
              'keys' => [
                'id' => '377656684087135',
                'secret' => '9e42a5411c3afba51d6ef229b5d4994d',
              ],
            ],
          ],
        ];
        try {
            /**
             * Feed configuration array to Hybridauth.
             */
            $hybridauth = new Hybridauth($config);
        
            /**
             * Initialize session storage.
             */
            $storage = new Session();
        
            /**
             * Hold information about provider when user clicks on Sign In.
             */
        	$getProvider='';//'Facebook'
            if (isset($provider)) {
                $getProvider=$provider;//'Facebook'
                $storage->set('provider', $provider);
            }
        
            /**
             * When provider exists in the storage, try to authenticate user and clear storage.
             *
             * When invoked, `authenticate()` will redirect users to provider login page where they
             * will be asked to grant access to your application. If they do, provider will redirect
             * the users back to Authorization callback URL (i.e., this script).
             */
            if ($provider_ = $storage->get('provider')) {
                // dd($provider_);
                $hybridauth->authenticate($provider_);
                $storage->set('provider', null);		
            }
        
            /**
             * This will erase the current user authentication data from session, and any further
             * attempt to communicate with provider.
             */
            if (isset($_GET['logout'])) {
                $adapter = $hybridauth->getAdapter($_GET['logout']);
                $adapter->disconnect();
            }
        	
        
            /**
             * Redirects user to home page (i.e., index.php in our case)
             */
        	 $adapters = $hybridauth->getConnectedAdapters();
        // 	 print_r($adapters);exit;
        // 	  print_r($adapters->getUserProfile());exit;
        // 	print_r($adapters['Facebook']->getUserProfile());
        	 $logedin=false;
        	 if ($adapters) : 
            	foreach ($adapters as $name => $adapter) :

            	    $email=$adapter->getUserProfile()->email;
            	    if($email=='')  $email=$adapter->getUserProfile()->identifier;
        			$data = [
                		'email'    => $name."-_-".$email,
                		'password' => $adapter->getUserProfile()->identifier.'@'.$name,
                		'name' => $adapter->getUserProfile()->firstName,
                		'role' => 1,
                		'username' => $name."-_-".$email,
                	
                	];
                   dd($data);
                   
                   $data2=[
                            "login"=> $name."-_-".$email,
                            "password"=>$adapter->getUserProfile()->identifier.'@'.$name
                         ];
                         
                         
                  dd('salam');       
                    if(Sentinel::authenticate($data2)){
                            return redirect(route('home'));
                    }else{
                    	$user=Sentinel::registerAndActivate($data);
                        if($user){
                            Sentinel::login($user);
                            $userid=$user->id;
                             ///////////////////////////////////notifications//////////////////////////////////////////
                            return  redirect(route('home'));    
                            //////////////////////////////////////////////////////////////////////////////////////////// 
                            //if($request->redirect) return  redirect($request->redirect);
                           // return  redirect(route('account'));
                        }
                    }
                endforeach;				
         	 endif;
        	 
        	 return redirect(route('login'));
        } catch (Exception $e) {
            return redirect(route('login'));
            echo $e->getMessage();
        }
        return redirect(route('login'));
    }

   
   
  
}
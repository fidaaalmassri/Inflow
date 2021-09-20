<?php


namespace App\Http\Controllers\LangController;



//use App\User;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class LangController extends Controller
{
   // use RedirectsUsers, ThrottlesLogins;
//
   // protected $redirectTo = '/ajax/logins';




    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request) {
        $in = '';

//        return $request->localLang;
        if(!\Session::has('localLang')){
            \Session::put('localLang' , $request->localLang);
//            \Session::save();

            $in = Input::get('localLang');
        }else {
            \Session::put('localLang' , $request->localLang);
            $in = Input::get('localLang');
        }

//        print_r(Session::get('localLang'));
//
//        die;

//        return $in;
        return redirect()->back();
    }

    public function changeToEn() {
        \Session::put('localLang' , 'en');
        return redirect()->back();
    }

    public function changeToAr() {
        \Session::put('localLang' , 'ar');
        return redirect()->back();
    }


}



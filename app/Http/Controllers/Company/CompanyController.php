<?php


namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;


use App\Companies;
use App\User;
use Illuminate\Http\Request;



class CompanyController extends Controller
{


    public function index(Request $request) {

        return view('auth.register_company');
    }


    
    public function store(Request $request)
    {

        //  return $request;
        $user_company = new user();
        $user_company->name= $request->fname;
        $user_company->email = $request->email;

        $user_company->password = Hash::make($request->password); 

        $user_company->role_id= 2; // role_id=2 => company account
        $user_company->save();

        $company = new Companies();
        $company->user_id = $user_company->id;
        $company->company_name = $request->company_name;
        $company->company_link = $request->company_link;
        $company->fname = $request->fname;
        $company->lname = $request->lname;
     

        $company->confirm_password = Hash::make($request->confirm_password);
        


        $company->save();




        return redirect(route('login'))->with('message', (' يمكنك تسجيل الدخول من هنا '));

        

    }


    public function show_profile($id)
    {
        $user = User::where('id', $id)->first();
        $company_user_info=Companies::where('user_id',$id)->first();
        // return $user;
        return view('company_dashboard.profile',compact("company_user_info", "user"));
    }
public function all_influencers(){

    return view('company_dashboard.influencers');
}
}



<?php


namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;


use App\Companies;
use App\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;


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

public function update_company_proile(Request $request, $id)
{
   
    $user_company = Companies::where('user_id', $id)->first();

    if (Auth::id() == $user_company->user_id) {
        $user_company->fname = $request->input('fname');
        $user_company->lname = $request->input('lname');


        $user_company->company_name = $request->input('company_name');
        $user_company->company_link = $request->input('company_link');
      

      
            $user_company->save();

        return back()->with('message_flash', sprintf(__("تم تعديل بياناتك بنجاح!")));
    } else {
        abort(404);
    }
}




public function changePassword( Request $request )
 {

        $validatedData = $request->validate( [
            'current-password' => 'required',
            'new-password' => 'required|string|min:6|confirmed',
        ] );

        if ( !( Hash::check( $request->get( 'current-password' ), Auth::user()->password ) ) ) {
            // The passwords matches
            //  return redirect()->back()->with( 'error', __( 'Your current password does not matches with the password you provided. Please try again.' ) );
            return redirect()->back()->with( 'error', __( 'كلمة المرور الحالية لا تتطابق مع كلمة المرور التي قدمتها. حاول مرة اخرى.' ) );
        }

        if ( strcmp( $request->get( 'current-password' ), $request->get( 'new-password' ) ) == 0 ) {
            //Current password and new password are same
            // return redirect()->back()->with( 'error', __( 'New Password cannot be same as your current password. Please choose a different password.' ) );
            return redirect()->back()->with( 'error', __( 'لا يمكن أن تكون كلمة المرور الجديدة هي كلمة المرور الحالية. يرجى اختيار كلمة مرور مختلفة.' ) );
        }

        //Change Password
        $user = Auth::user();
        $user->password = bcrypt( $request->get( 'new-password' ) );
        $user->save();
        $user_company = Companies::where( 'user_id', $user->id )->first();
        $user_company->confirm_password = $user->password;
        $user_company->save();
        return back()->with( 'message_flash', __( 'تم تغيير كلمة المرور الخاصة بك بنجاح!' ) );
    }
}



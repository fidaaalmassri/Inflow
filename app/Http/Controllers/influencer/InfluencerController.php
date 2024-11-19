<?php





namespace App\Http\Controllers\influencer;



use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Hash;



use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;

use App\Companies;

use App\User;

use App\Influence;

use Illuminate\Http\Request;







class InfluencerController extends Controller

{

    public function show_profile($id)

    {

        $user = User::where('id', $id)->first();

        $influence= Influence::where('user_id', $id)->first();

        // dd($influence);

        return view('influencer_dashboard.profile',compact("user","influence"));

    } 

    public function updateOrCreate(Request $request)
    {

        $request->validate([

            'fname' => ['required', 'string', 'max:255'],

             'lname' => ['required', 'string', 'max:255'],

            // 'email' => ['required', 'email', 'max:255', 'unique:users'],

            'gender' => ['required'],

            // 'phone' => ['required', 'numeric'],

            'birthday' => ['required'],

            'location' => ['required'],

            // 'avater' => ['image'],
        ]);

        $fname =$request->input('fname');

        $lname =$request->input('lname');

       $gender =$request->input('gender');

      $birthday=$request->input('birthday');

    //   $birthday = Carbon::createFromFormat('d/M/Y', $request->input('birthday'))->format('d-M-Y');

    //   $birthday = Carbon::createFromFormat('m/d/Y', $request->input('birthday'));

    //   $birthday =  Carbon::parse($birthday)->format('d/m/Y');
     //  $birthday = Carbon::createFromFormat('d/m/Y', $birthday)->format('Y-m-d');



    //    $birthdayfor = Carbon::createFromFormat('m/d/Y', $request->input('birthday'));

    //    $birthday =$birthdayfor ;

       $location =$request->input('location');

       $description=$request->input('description');



        $influence_exist = Influence::select('*')

       ->where('user_id', Auth::user()->id)

        ->first();
   if($influence_exist == null)//if doesn't exist: create

   {

       $influence = Influence::create([

        'user_id'   => Auth::user()->id,

            'fname' => $fname,

            'lname' => $lname,

            'gender' => $gender,

            'birthday' =>  $birthday,

            'location' => $location,

            'description'    => $description

       ]); 

   }

   else //if exist: update

   {

       //$processes = Process::where('id', $processexist->id)

          // ->update(['weight'=>sum($weight->weight)]);



       // you already retrieved the record and it exists, so just update it.

       $influence_exist->update([
        'fname' => $fname,

            'lname' => $lname,

            'gender' => $gender,

            'birthday' => $birthday,

            'location' => $location,

            'description'    => $description
    ]);

   }
        // $influence = \App\Influence::updateOrCreate([

        //     //Add unique field combo to match here

        //     //For example, perhaps you only want one entry per user:

        //     'user_id'   => Auth::user()->id,

        // ],[

        //     'fname' => $fname,

        //     'lname' => $lname,

        //     'gender' => $gender,

        //     'birthday' => $birthday,

        //     'location' => $location,

        //     'address'   => $request->get('address'),

        //     'description'    => $description

        // ]); 

        $user = User::where('id', Auth::user()->id)->first();

        $influence=$influence_exist;

        // dd(\Carbon\Carbon::parse($influence->birthday )->format('d/m/Y'));

        // return view('influencer_dashboard.profile',compact("user","influence"));

        return redirect(route('profile_influencer',['id'=>auth()->user()->id]))->with('message', (' تم التعديل بنجاح !'));



    }



    public function socialMedia($id)

    {

        $user = User::where('id', $id)->first();

        

        return view('influencer_dashboard.socialMedia',compact("user"));

    }

    public function audienceDemographics($id)

    {

        $user = User::where('id', $id)->first();

        

        return view('influencer_dashboard.audienceDemographics',compact("user"));

    }



}
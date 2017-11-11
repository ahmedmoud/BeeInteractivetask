<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use DB;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home';
    
    

       public function Login(Request $request){
          $email = $this->make_safe($request->input('email'));
          $password = $this->make_safe($request->input('password'));
             
     $result = DB::table('bi_user')->get()->where('password', md5($password))->where('email',$email);
     
     if(count($result)){
         foreach ($result as $row );
         $info = DB::table('bi_user_type')->get()->where('id',$row->user_type_id);
         if(count($info)){
             foreach ($info as $row);
             
         }
         return view('home',['result'=>'welcome','info'=>$row->role]);
     }else {
         return view('login',['result'=>'invalid email or password']);
         
     }
}
 
    public function make_safe($variable) {
      $variable = strip_tags($variable);
      $variable = stripslashes($variable);
        return $variable;
        
    }
    
    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function Flogin($email){
        
     $result = DB::table('bi_user')->get()->where('email',$email);
     if($result){
         foreach ($result as $row );
         $info = DB::table('bi_user_type')->get()->where('id',$row->user_type_id);
         if(count($info)){
             foreach ($info as $row);
        }
         return view('home',['result'=>'welcome','info'=>$row->role]);
         
         }
     else {
         return view('login',['result'=>'invalid email or password']);
         
     }
     
    }

    public function handleProviderCallback()
    {
        $user  = Socialite::driver('facebook')->user();
         $email = $user->email;
         return $this->Flogin($email);
    }
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}

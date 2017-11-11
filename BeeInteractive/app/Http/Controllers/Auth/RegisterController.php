<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use DB;
class RegisterController extends Controller
{
      public function registration(Request $request) {
        
         $name = $this->make_safe($request->input('name'));
        $password = $this->make_safe($request->input('password'));
        $cpassword = $this->make_safe($request->input('cpassword'));
        $email = $this->make_safe($request->input('email'));
        $role = $this->make_safe($request->input('role'));
        $safe = $this->make_safe_email($this->make_safe($email));
        $exist = $this->exist($email);
        if(!isset($name)){
            return view('home',['result'=>'please enter the name']);
        }
        
        if(!isset($password)){
            return view('home',['result'=>'please enter the password']);
        }
        
        if(!isset($email)){
            return view('home',['result'=>'please enter the email']);
        }
        
        if(!isset($role)){
            return view('home',['result'=>'please enter the role']);
        }
        if(!$safe&&$exist){
         return view('home',['result'=>'invalid email or not exist email']);
        }
        $validpassword=$this->make_safe_password($password);
        if(!$validpassword){
            return view('home',['result'=>'password must consist of 8 characters at least and must have at least 1 capital letter , small letter and number']);
        }
        if($cpassword!=$password){
            return view('home',['result'=>'passwords dont match']);
            }
        $num_rows = DB::table('bi_user')->get()->where('email',$email);
        $date = date("Y-m-d");
        if(!count($num_rows)){
         $result = DB::table('bi_user')->insert(['name'=>$name,'password'=>md5($password),'user_type_id'=>$role,'email'=>$email,'created_at'=>$date,'updated_at'=>$date]);
        if($result) {return view('home',['result'=>'success']);}
        else {return view('home',['result'=>'fail']); }
        }
        else {
            return view('home',['result'=>'change email']);
        }
    }

     public function make_safe($variable) {
      $variable = strip_tags($variable);
      $variable = stripslashes($variable);
        return $variable;
        
    }
    public  function exist($email, $record = 'MX'){
            list($user, $domain) = explode('@', $email);
            return checkdnsrr($domain, $record);
        }
    public function make_safe_email($variable) {

        $result = preg_match('/[a-zA-Z0-9]+@/',$variable);
        return $result;
    }
    public function make_safe_password($variable) {

        $result = preg_match('/[a-z]/',$variable);
        $result &= preg_match('/[A-Z]/',$variable);
        $result &= preg_match('/[0-9]/',$variable);
        
        return $result&&strlen($variable)>=8;
    }

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
}

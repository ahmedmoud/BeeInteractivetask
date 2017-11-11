<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class userCon extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
     
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        
        
        $name = $request->input('name');
        $password = $request->input('password');
        $email = $request->input('email');
        $role = $request->input('role');
        $safe = $this->make_safe_email($email);
        $exist = $this->exist($email);
        if(!isset($name)){
            return view('registration',['result'=>'please enter the name']);
        }
        
        if(!isset($password)){
            return view('registration',['result'=>'please enter the password']);
        }
        
        if(!isset($email)){
            return view('registration',['result'=>'please enter the email']);
        }
        
        if(!isset($role)){
            return view('registration',['result'=>'please enter the role']);
        }
        if(!$safe&&$exist){
         return view('home',['result'=>'invalid email or not exist email']);
        }
        $validpassword=$this->make_safe_password($password);
        if(!$validpassword){
            return view('home',['result'=>'invalid password']);
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

    
    public  function exist($email, $record = 'MX'){
            list($user, $domain) = explode('@', $email);
            return checkdnsrr($domain, $record);
        }
    public function make_safe_email($variable) {

        $result = preg_match('/[a-zA-Z0-9]+@/',$variable);
        return $result;
    }
    public function make_safe_password($variable) {

        $result = preg_match('/[a-z+A-Z+0-9]/',$variable);
        return $result&&strlen($variable)>=8;
    }
    
    public function show($email,$password)
    {
      
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

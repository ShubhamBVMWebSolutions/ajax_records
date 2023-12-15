<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Session;
use Hash;

class LoginController extends Controller
{
   
    public function admin_login(Request $request) {
        $request->validate([
            'email' => 'required',
            'password'=>'required',
        ]);
            $email = $request->email;
            $password = $request->password;
        $user = User::where('email', $email)->first();
        if($user == null){
            return redirect()->back()->with('error', 'please check the email.');
        }else {
            $hashed_pass = $user->password;
            $user_id=$user->id;
            $username = $user->name;
            $email = $user->email;
            $type= $user->type;
            if (Hash::check($password, $hashed_pass)) {
                // Session::put('username', $username);
                Session::put(['user_id'=>$user_id,'username' =>$username, 'email' => $email,'type'=>$type]);
                if ($type =='1') {
                    // return view('admin.dashboard');
                  return redirect()->route('home');
                } else {
                  return redirect()->route('user_dashboard');
                    
                }
            }else{
                return redirect()->back()->with('error','Password Or Email-Address is not correct.');
            }
        }
    }

    public function admin_register(Request $request) {
        $User = new User;
        $User->name= $request->name;
        $User->email= $request->email;
        $User->password= $request->password;
        $saved_user =$User->save();
        if($saved_user){
            $my_user = User::where('email', $User->email)->first();
            $user_id=$my_user->id;
            $username = $my_user->name;
            $email = $my_user->email;
            Session::put(['user_id'=>$user_id,'username' =>$username, 'email' => $email]);
            return redirect()->route('user_dashboard');
      }
    }


    public function logout(Request $request)
    {
        Session::flush();
        return redirect()->route('main');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;

class PatronAuthenticationController extends Controller
{
    public function showLoginBoard(){
        return view('login_board');
    }

    public function login(Request $request){
        $request-> validate([
            'username' => 'required',
            'password'=> 'required',
        ]);

        $username = $request->input('username');
        $password = $request->input('password');
        
        $account_type = DB::table('patron_account')->where('email', $username)->value('account_type');

        //  $hashedPW = md5($password);

        $user = DB::table('patron_account')
            ->where('email', $username)
            ->where('password', $password)
            ->first();

        if($user){
            if($account_type == 'patron'){
                // call liveiwre class: "StudentDashboard.php"
                return redirect()->route('student.dashboard');
            } else{
                return redirect()->route('admin.dashboard');
            }

        } else {
            return "Login Failed.";
        }
            
        

    }
}

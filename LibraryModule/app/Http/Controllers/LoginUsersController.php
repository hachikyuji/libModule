<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoginUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginUsersController extends Controller
{
    public function getAccounts(Request $request)
    {
        $users = LoginUser::all();

        return view('loginuser.loginuser_table', ['users' => $users]);
    }

    public function auto_login($id, $password, $role_id)
    {

        $user = User::where('usernum', $id)->first();

        if ($user) {
            Auth::login($user);

            if ($role_id == 43){
                return redirect()->intended('dashboard');
            } else {
                return redirect()->intended('patron_dashboard');
            }

        }

        return back()->withErrors([
            'id' => 'The provided credentials do not match our records.',
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Session;

class TempRegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('temp_register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'middle_initial' => ['nullable', 'string', 'max:1'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'user_num' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'account_type' => ['required'],
            'college' => ['nullable','string', 'max:255'],
            'course' => ['nullable','string', 'max:255'],
        ]);
        
        if ($request->middle_initial){
            $name = $request->first_name . ' ' . $request->middle_initial . ' ' . $request->last_name;
        } else {
            $name = $request->first_name . ' ' . $request->last_name;
        }
        
    
        $user = User::create([
            'name' => $name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'account_type' => $request->account_type,
            'usernum' => $request->user_num,
            'college' => $request->college,
            'course' => $request->course,
        ]);
    
        event(new Registered($user));
        Session::flash('success', 'Account creation successful.');
    
        return redirect(RouteServiceProvider::LOGIN);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

class AccountController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function account(){
        $user = Auth::user();
        return view('account_form', compact('user'));
    }

    public function accountPost(Request $request){

        $user = Auth::user();

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'nullable|min:8|confirmed',
        ],[
            'name.required' => 'Ruangan nama adalah wajib',
            'email.unique' => "dah ada orang guna email ni",
        ]);

        $user->name = $request['name'];
        $user->email = $request['email'];
        if($request['password']){
            $user->password = bcrypt($request['password']);
        }

        $user->save();

        Session()->flash('success-msg', 'Your profile has been updated.');
        return redirect()->route('account.account');

    }
}

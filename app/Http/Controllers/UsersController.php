<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Auth;

use Illuminate\Http\Request;

class UsersController extends Controller {

	//
    public function showmy()
    {
        $user=Auth::user();

        return view('users/profile', compact('user'));
    }
    public function manage()
    {
        if (Auth::guest()){
            return redirect('/');
        }
        elseif (Auth::user()->level<2){
            return redirect('/');
        }

        $users=User::latest()->get();
        return view('users/manage', compact('users'));
    }
    public function validation()
    {
        if (Auth::guest()){
            return redirect('/');
        }
        elseif (Auth::user()->level<2){
            return redirect('/');
        }

        $users=User::where('confirmed',false)->get();
        return view('users/validate', compact('users'));
    }

}

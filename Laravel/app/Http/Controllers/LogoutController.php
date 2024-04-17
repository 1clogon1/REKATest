<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{

    public function Logout(Request $request){
        $user = Auth::user()->makeHidden(['id']);
        $user_id = User::where('id',$user->id)->first();
        if($user!=null){

            //Удаляем сессию с пользователем
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();
            $user_id->remember_token = NULL;
            $user_id->update();
            return redirect()->route('ToDo_View');
        }

    }

}

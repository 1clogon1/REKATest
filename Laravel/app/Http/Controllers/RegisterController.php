<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{


    //Авторизация
    function Register(Request $request){
        $valid = Validator::make($request->all(),[
            'name'=>'required|regex:/^[А-аЯ-яЁё]+$/u|max:100|min:6',
            'surname'=>'required|regex:/^[А-аЯ-яЁё]+$/u|max:100|min:6',
            'patronymic'=>'required|regex:/^[А-аЯ-яЁё]+$/u|max:100|min:6',
            'email'=>'required|max:100|min:6|unique:User|email',
            'password'=>'required|max:100|min:8',
            'password_confirmation'=>'same:password',
            'checkbox'=>'accepted'
        ]);
        if($valid->fails()){
            return response()->json([
                'status'=>400,
                'errors'=>$valid->messages()
            ]);
        }
        else{
            $user = User::create([
                'name'=>$request->name,
                'surname'=>$request->surname,
                'patronymic'=>$request->patronymic,
                'email'=>$request->email,
                'password'=>Hash::make($request->password),
                'remember_token'=>Str::random(80)
            ]);

            Auth::login($user);

            return response()->json([
                'status'=>200,
                'message'=>"Успешная регистрация",
            ]);

        }

    }


}

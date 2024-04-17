<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;


class LoginController extends Controller
{

    //Авторизация
    public function Login(Request $request){
        $valid = $request->validate([
            'email'=> 'required|max:100|min:6|email',
            'password'=>'required|string'
        ]);
        //При неудачном входе возвращает нас назад
        if(!Auth::attempt($valid, $request->boolean('remember'))){//$request->boollean('remember') - второй аргумент для проверки люди нажили остаться в системе или нет, если нажмем то в базе появится токен, а на сайте новы куки храняший данный токен
            throw  ValidationException::withMessages([//Вариант валидации вместо нижних 4 строк, если пользователь не был найден то перенаправить его на страницу входа и выведет сообщение, то есть не в ручную все прописывать, а использовать встроенное
                //'email'=>'Введенные данные для входа не соответствуют ни одной записи в базе'
                'login'=>trans('auth.failed')//Считываем фразу ошибки из системы(так как там они хранятся заранее, но можно и сои слова добавить)
            ]);
        }


        //Обновляем сессию
        $request->session()->regenerate();

        $user = Auth::user()->makeHidden(['id']);
        $user->remember_token = Str::random(80);
        $user->update();
        return redirect()->route('ToDo_View');

    }

}

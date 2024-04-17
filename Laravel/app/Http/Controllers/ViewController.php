<?php

namespace App\Http\Controllers;


use App\Models\Note;
use App\Models\NoteList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ViewController extends Controller
{

    //Контроллер для вывода страниц
    public function Welcome_View(){
        return view('welcome');
    }


    public function Login_View(){
        return view('login');
    }

    public function Register_View(){
        return view('register');
    }

    public function ToDo_View(Request $request){
        $user = Auth::user();
        $List= NoteList::where('user_id',$user->id)->latest()->get();
        $request->session()->forget('filter');
        $request->session()->forget('filter_txt');
        return view('todo',[
            'list'=>$List,
            'user_id'=>$user->id
        ]);

    }

    public function ImageNote_View( $id){

        $Note = Note::where('id', $id)->first();

            return view('imageNote', [
                'idNote' => $id,
                'idList' => $Note->list_id,
                'imageNote'=> $Note->image,
                'nameNote'=> $Note->name,
            ]);

    }

}

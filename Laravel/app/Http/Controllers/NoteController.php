<?php

namespace App\Http\Controllers;

use App\Models\NoteList;
use App\Models\Note;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class NoteController extends Controller
{

    function AddList(Request $request)
    {
        $user = Auth::user();
        $valid = Validator::make($request->all(), [
            'nameList' => 'required|String|max:50|min:3',

        ]);
        if ($valid->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $valid->messages()
            ]);
        } else {
            NoteList::create([
                'name' => $request->nameList,
                'user_id' => $user->id,
            ]);

            return response()->json([
                'status' => 200,
                'message' => "Список создан",
            ]);

        }

    }

    function AddNote(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'nameNote' => 'required|String|max:100|min:3',
            'idList' => 'required|String|max:100',
        ]);
        if ($valid->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $valid->messages()
            ]);
        } else {
            Note::create([
                'name' => $request->nameNote,
                'list_id' => $request->idList,
            ]);

            return response()->json([
                'status' => 200,
                'message' => "Запись создан",
            ]);

        }

    }


    function NoteList(Request $request, $id)
    {
        $request->session()->forget('filter');
        $request->session()->forget('filter_txt');
        $Note = Note::where('list_id', $id)->latest()->get();
        $result = [];

        for ($i = 0; $i != Count($Note); $i++) {
            $Tag = Tag::where('note_id', $Note[$i]->id)->latest()->get();
            $Note_Tag = [
                'id' => $Note[$i]->id,
                'name' => $Note[$i]->name,
                'list_id' => $Note[$i]->list_id,
                'checked' => $Note[$i]->checked,
                'image' => $Note[$i]->image,
                'created_at' => $Note[$i]->created_at,
                'updated_at' => $Note[$i]->updated_at,
                'tag' => $Tag,

            ];
            array_push($result, $Note_Tag);
        }


        return view('todoid', [
            'note' => $result,
            'idList' => $id,
        ]);

    }

//    function NoteList($id)
//    {
//        $Note = Tag::where('list_id', $id)->latest()->get();
//
//        $result = [];
//
//        for ($i = 0; $i != Count($Note); $i++) {
//            $Tag = Tag::where('note_id', $Note[$i]->id)->latest()->get();
//
//            array_push($result, $Tag);
//        }
//
//        return view('todoid', [
//            'note' => $Note,
//            'tag' => $result,
//            'idList' => $id,
//        ]);
//    }

    function AddChecked(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'idNote' => 'required|String|max:100',
        ]);
        if ($valid->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $valid->messages()
            ]);
        } else {
            $Note = Note::where('id', $request->idNote)->first();
            if ($Note->checked == 1) {
                $Note->checked = 0;
                $Note->update($request->input());
            } else {
                $Note->checked = 1;
                $Note->update($request->input());
            }

            return response()->json([
                'status' => 200,
                'message' => "Отмечено",
            ]);

        }
    }


    function AddNoteTag(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'nameNoteTag' => 'required|String|max:100|min:2',
            'idNote' => 'required|numeric',
        ]);
        if ($valid->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $valid->messages()
            ]);
        } else {
            $tag = Tag::create([
                'name' => $request->nameNoteTag,
                'note_id' => $request->idNote,
            ]);

            return response()->json([
                'status' => 200,
                'message' => "Tag создан",
            ]);

        }

    }

    function TagArr($id)
    {
        $Tag = Tag::where('note_id', $id)->latest()->get();
        return view('tagArr', [
            'tag' => $Tag,
        ]);
    }

    function DeleteNote(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'idNote' => 'required|numeric',
        ]);
        if ($valid->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $valid->messages()
            ]);
        } else {
            $Note = Note::where('id', $request->idNote)->first();
            $Note->delete();

            return response()->json([
                'status' => 200,
                'message' => "Запись удалена",
            ]);
        }

    }

    function DeleteTag(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'idTag' => 'required|numeric',
        ]);
        if ($valid->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $valid->messages()
            ]);
        } else {
            $Tag = Tag::where('id', $request->idTag)->first();
            $Tag->delete();

            return response()->json([
                'status' => 200,
                'message' => "Запись удалена",
            ]);
        }

    }

    function ClearTag(Request $request)
    {
        $request->session()->forget('filter');
        $request->session()->forget('filter_txt');
    }

    function NoteArr(Request $request, $id)
    {

        if ($request->session()->has('filter') && $request->session()->has('filter_txt')) {
            $ses_filter = $request->session()->get('filter');
            if (count($ses_filter) == 1) {
                $Note = Note::latest()
                    ->join('tag', 'tag.note_id', 'note.id')
                    ->select('note.id', 'note.name', 'note.list_id', 'note.checked', 'note.image', 'note.created_at', 'note.updated_at')
                    ->where('note.list_id', $id)
                    ->where('tag.name', $ses_filter[0])
                    ->get();
            } elseif (count($ses_filter) == 2) {
                $Note = Note::latest()
                    ->join('tag', 'tag.note_id', 'note.id')
                    ->select('note.id', 'note.name', 'note.list_id', 'note.checked', 'note.image', 'note.created_at', 'note.updated_at')
                    ->where('note.list_id', $id)
                    ->where('tag.name', $ses_filter[0])->orwhere('tag.name', $ses_filter[1])
                    ->get();
            } elseif (count($ses_filter) == 3) {
                $Note = Note::latest()
                    ->join('tag', 'tag.note_id', 'note.id')
                    ->select('note.id', 'note.name', 'note.list_id', 'note.checked', 'note.image', 'note.created_at', 'note.updated_at')
                    ->where('note.list_id', $id)
                    ->where('tag.name', $ses_filter[0])->orwhere('tag.name', $ses_filter[1])->orwhere('tag.name', $ses_filter[2])
                    ->get();
            }

        } else {
            $Note = Note::where('list_id', $id)->latest()->get();
        }

        $result = [];

        for ($i = 0; $i != Count($Note); $i++) {
            $Tag = Tag::where('note_id', $Note[$i]->id)->get();
            $Note_Tag = [
                'id' => $Note[$i]->id,
                'name' => $Note[$i]->name,
                'list_id' => $Note[$i]->list_id,
                'checked' => $Note[$i]->checked,
                'image' => $Note[$i]->image,
                'created_at' => $Note[$i]->created_at,
                'updated_at' => $Note[$i]->updated_at,
                'tag' => $Tag,

            ];
            array_push($result, $Note_Tag);
        }

        return view('noteArr', [
            'note' => $result,
            'idList' => $id,
        ]);

    }

    function ListArr($id)
    {
        $user = Auth::user();
        $List = NoteList::where('user_id', $id)->latest()->get();

        return view('listArr', [
            'list' => $List,
            'user_id' => $user->id
        ]);
    }

//    public function AddImageNote(Request $request)
//    {
//
//        $valid = Validator::make($request->all(),[
//            'id' => 'required|numeric',
//            'image' => 'required|mimes:jpg,png,jpeg,gif,svg'
//        ]);
//
//                $Note = Note::where('id',$request->id)->first();
//                if ($Note != null) {
//                    $path = $request->image->store('images', 'public');
//                    $url = str_replace('images/', '', $path);
//                    $Note->image = $url;
//                    $Note->update();
//                }
//
//        return response()->json([
//                'status' => 200,
//                'message' => "Фотографию добавлена",
//            ]);
//    }


    function AddFilterList(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'name' => 'required|String|max:100|min:2',
        ]);

        if ($request->session()->has('filter') && $request->session()->has('filter_txt')) {
            $ses_filter = $request->session()->get('filter');
            $filter_txt = $request->session()->get('filter_txt');
            if (count($ses_filter) <= 2) {
                array_push($ses_filter, $request->name);
                session(['filter' => $ses_filter]);
                session(['filter_txt' => $filter_txt .= count($ses_filter)." - ".$request->name."; "]);
            }
            return view('filterTag', [
                'name' => $filter_txt,
            ]);
        } else {
            $filter = [];
            array_push($filter, $request->name);
            session(['filter' => $filter]);
            session(['filter_txt' => "1 - ".$request->name." "]);
            return view('filterTag', [
                'name' => "1 - ".$request->name." ",
            ]);
        }


        //Удаление
        //$request->session()->forget('filter');


    }


    function ImageNameModel($id)
    {

        $Note = Note::where('id', $id)->get();

        return view('imageModel', [
            'note' => $Note,
        ]);
        return response()->json([
            'status' => 200,
            'message' => "Ошибка при добавление фотографии",
        ]);
    }


    function UpdateImage(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'idNote' => 'required|numeric',
            'image' => 'required|mimes:jpg,png,jpeg,gif,svg'
        ]);

        $Note = Note::where('id', $request->idNote)->first();
        if ($Note != null) {
            $path = $request->image->store('images', 'public');
            $url = str_replace('images/', '', $path);
            $Note->image = $url;
            $Note->update();
            return response()->json([
                'status' => 200,
                'message' => "Фотографию добавлена",
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "Ошибка при добавление фотографии",
            ]);
        };
    }

    function UpdateName(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'idNote' => 'required|numeric',
            'name' => 'required|String|max:100|min:3',
        ]);

        $Note = Note::where('id', $request->idNote)->first();
        if ($Note != null) {
            $Note->name = $request->name;
            $Note->update();
            return response()->json([
                'status' => 200,
                'message' => "Название добавлена",
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "Ошибка при добавление Название",
            ]);
        }
    }

    function DeleteImage(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'idNote' => 'required|numeric',
        ]);
        if ($valid->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $valid->messages()
            ]);
        } else {
            $Note = Note::where('id', $request->idNote)->first();
            if ($Note != null) {
               // Storage::delete('');
                $Note->image = null;
                $Note->update($request->input());
            }
            return response()->json([
                'status' => 200,
                'message' => "Фотографию удалена",
            ]);

        }
    }


}

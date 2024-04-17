<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ViewController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/Login', [ViewController::class,'Login_View'])->middleware('guest')->name("Login_View");
Route::get('/Register', [ViewController::class,'Register_View'])->middleware('guest')->name("Register_View");
Route::get('/', [ViewController::class,'ToDo_View'])->middleware('auth')->name("ToDo_View");
Route::get('/imageNote/{id}', [ViewController::class,'ImageNote_View'])->middleware('auth')->name("ImageNote_View");


//Авторизация
Route::post('/Register', [RegisterController::class,'Register'])->middleware('guest')->name("Register");
Route::post('/Login', [LoginController::class,'Login'])->middleware('guest')->name("Login");
Route::get('/Logout', [LogoutController::class,'Logout'])->middleware('auth')->name("Logout");

Route::POST('/AddList', [NoteController::class,'AddList'])->middleware('auth')->name("AddList");


Route::GET('/NoteList/{id}',[NoteController::class,'NoteList'])->middleware('auth')->name("NoteList");
Route::POST('/AddNote',[NoteController::class,'AddNote'])->middleware('auth')->name("AddNote");
Route::PATCH('/AddChecked',[NoteController::class,'AddChecked'])->middleware('auth')->name("AddChecked");
Route::POST('/AddNoteTag',[NoteController::class,'AddNoteTag'])->middleware('auth')->name("AddNoteTag");
Route::DELETE('/DeleteNote',[NoteController::class,'DeleteNote'])->middleware('auth')->name("DeleteNote");
Route::DELETE('/DeleteTag',[NoteController::class,'DeleteTag'])->middleware('auth')->name("DeleteTag");

Route::GET('/NoteArr/{id}',[NoteController::class,'NoteArr'])->middleware('auth')->name("NoteArr");
Route::GET('/TagArr/{id}',[NoteController::class,'TagArr'])->middleware('auth')->name("TagArr");
Route::GET('/ImageNameModel/{id}',[NoteController::class,'ImageNameModel'])->middleware('auth')->name("ImageNameModel");

Route::GET('/ListArr/{id}',[NoteController::class,'ListArr'])->middleware('auth')->name("ListArr");

Route::POST('/UpdateImage', [NoteController::class,'UpdateImage'])->middleware('auth')->name("UpdateImage");
Route::POST('/UpdateName', [NoteController::class,'UpdateName'])->middleware('auth')->name("UpdateName");

Route::DELETE('/DeleteImage',[NoteController::class,'DeleteImage'])->middleware('auth')->name("DeleteImage");

Route::GET('/FilterList',[NoteController::class,'FilterList'])->middleware('auth')->name("FilterList");
Route::GET('/ClearTag',[NoteController::class,'ClearTag'])->middleware('auth')->name("ClearTag");

Route::POST('/AddFilterList',[NoteController::class,'AddFilterList'])->middleware('auth')->name("AddFilterList");

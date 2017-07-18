<?php

use App\Events\MessagePosted;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


//RETURNING CHAT ROOM VIEW
Route::get('/chat',function(){
    return view('chat');
})->middleware('auth');

Route::get('/messages',function(){
   return App\Message::with('user')->get();
})->middleware('auth');

Route::post('/messages',function(){
    //STORE THE NEW MESSAGE
    $user = Auth::user();
    $message = $user->message()->create([
        'message' => request()->get('message')
    ]);

//    ANNOUNCHING THAT MESSAGE HAS SEND

        event(new MessagePosted($message,$user));
    return ['status' => 'MESSAGE SENT'];
})->middleware('auth');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

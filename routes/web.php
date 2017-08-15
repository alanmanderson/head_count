<?php
use Alanmanderson\HeadCount\Models\Event;
use Alanmanderson\HeadCount\Models\Occurrence;
use Alanmanderson\HeadCount\Notifications\EventRsvp;

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

Route::get('reply', 'ReplyController@reply');

Route::get('test', function() {
    $e = Event::find(2);
    Notification::send($e->users, new EventRsvp(Occurrence::find(1)));
});
<?php
use Alanmanderson\HeadCount\Models\Event;
use Alanmanderson\HeadCount\Models\Occurrence;
use Alanmanderson\HeadCount\Notifications\EventRsvp;
use Alanmanderson\HeadCount\Notifications\EventReport;
use Alanmanderson\HeadCount\Models\Reply;
use Cron\CronExpression;
use Illuminate\Support\Facades\Notification;

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
Route::get('text_reply', 'ReplyController@textReply');

Route::get('test', function() {
    $e = Event::find(1);
    $cron = CronExpression::factory($e->schedule);
    $occurrence = Occurrence::create([
        'event_id'=>$e->id,
        'start_time'=>$cron->getNextRunDate()->format('Y-m-d H:i:s')
    ]);

    Notification::send($e->users, new EventRsvp($occurrence));
    //$e = Event::find(2);
    //Notification::send($e->users, new EventRsvp(Occurrence::find(1)));
});

Route::get('testSecret', function(){
    $base_url = 'https://rest.nexmo.com/sms/json?';
    $security_secret = env('NEXMO_SECURITY_SECRET');

    //The timestamps used in the signature are in UTC + 0
    date_default_timezone_set('UTC');

    $params = [
        'api_key' =>  env('NEXMO_API_KEY'),
        'to' => '16177808043',
        'from' => '12034569956',
        'text' => 'Hello from Nexmo',
        'type' => 'text',
        'timestamp' => time() - date('Z')
    ];

    //sort your parameters
    ksort($params);

    //create base string
    $signing_url = '&' . urldecode(http_build_query($params)) . $security_secret;

    //Add your md5 hash of your parameters to your parameters
    $params['sig'] = md5($signing_url);

    //Create your request URL
    $url = $base_url . http_build_query($params);

    //Run your request
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);

    echo $response;
});

Route::get('test1', function() {
    $yeses = [
            new Reply(["user_id" => 1, "occurrence_id" =>1, "likelihood" => 1]),
            new Reply(["user_id" => 2, "occurrence_id" =>1, "likelihood" => 1]),
            new Reply(["user_id" => 3, "occurrence_id" =>1, "likelihood" => 1]),
            new Reply(["user_id" => 4, "occurrence_id" =>1, "likelihood" => 1])
    ];
    return view('mail.report')
        ->with([
                'yeses' => $yeses,
                'maybes' => Reply::whereLikelihood(.5)->get(),
                'nos' => []
        ]);
});

Route::get('report', function() {
    $e = Event::find(1);
    $occurrence = $e->occurrences->last();
    $replies = $occurrence->replies;
    $user = [];
    foreach($replies as $reply){
        $users[] = $reply->user;
    }
    $a = Notification::send($users, new EventReport($replies));
    return $a;
    return $occurrence;
});

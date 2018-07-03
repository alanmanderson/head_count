<?php

namespace Alanmanderson\HeadCount\Http\Controllers;

use \Exception;
use Alanmanderson\HeadCount\Models\Event;
use Alanmanderson\HeadCount\Models\Reply;
use Alanmanderson\HeadCount\Models\User;
use Alanmanderson\HeadCount\Notifications\BadSmsResponse;
use Alanmanderson\HeadCount\Notifications\BadUserResponse;
use Alanmanderson\HeadCount\Services\NexmoInboundSms;
use Illuminate\Http\Request;

class ReplyController extends Controller {
    public function reply(Request $request) {
        $userGuid = $request->input('id');
        $user = User::whereGuid($userGuid)->firstOrFail();
        $occuranceId = $request->input('occurrence_id');
        $likelihood = $request->input('likelihood');
        $reply = Reply::updateOrCreate([
                'user_id'=>$user->id,
                'occurrence_id'=>$occuranceId],
                ['likelihood'=>$likelihood]
        );
        return $reply;
    }

    public function textReply(Request $request) {
        $phoneNumberHandler = app('PhoneNumberHandler');
        $sms = new NexmoInboundSms(
            $request->input('type'),
            $phoneNumberHandler->normalize($request->input('to')),
            $phoneNumberHandler->normalize($request->input('msisdn')),
            $request->input('messageId'),
            $request->input('message-timestamp'),
            $request->input('text'),
            $request->input('keyword'));
        try {
            $user = User::wherePhone($sms->from)->firstOrFail();
        } catch(Exception $e) {
            return "Not a customer";
        }

        $response = strtolower(substr($sms->keyword, 0, 1));
        $eventId = substr($sms->keyword, 1);
        if (!$user->isMemberOfEvent($eventId)) { return "NOT A MEMBER"; }

        $responseArr = ['y' => 1, 'n' => 0, 'm' => .5];
        try{
            $likelihood = $responseArr[$response];
        } catch(Exception $e) {
            $user->notify(new BadSmsResponse($sms));
            $admin = User::find(env('ADMINISTRATOR_ID'));
            $admin->notify(new BadUserResponse($sms));
            return "Invalid Response: {$sms->keyword}";
        }

        $event = Event::find($eventId);
        $occurrence = $event->occurrences->last();
        Reply::updateOrCreate(
            ['user_id' => $user->id, 'occurrence_id' => $occurrence->id],
            ['likelihood' => $likelihood]
        );
    }
}

<?php

use Alanmanderson\HeadCount\Models\Occurrence;
use Alanmanderson\HeadCount\Notifications\EventRsvp;
use Cron\CronExpression;
use Illuminate\Foundation\Inspiring;
use Illuminate\Notifications\Notification;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('occurrence:create {event_id}', function(int $event_id) {
    $e = Event::find($event_id);
    $cron = CronExpression::factory($e->schedule);
    $occurrence = Occurrence::create([
        'event_id' => $e->id,
        'start_time' => $cron->getNextRunDate()->format('Y-m-d H:i:s')
    ]);
    $this->info($occurrence);
})->describe('Create an instance of an event');

Artisan::command('users:notify {occurrence_id}', function(int $occurrence_id) {
    $occurrence = Occurrence::find($occurrence_id);
    Notification::send($occurrence->event->users, new EventRsvp($occurrence));
})->describe('Notify all users for the given occurence.');

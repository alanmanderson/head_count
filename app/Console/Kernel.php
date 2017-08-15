<?php

namespace Alanmanderson\HeadCount\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Alanmanderson\HeadCount\Models\Event;
use Illuminate\Notifications\Notification;
use Alanmanderson\HeadCount\Notifications\EventRsvp;
use Cron\CronExpression;
use Alanmanderson\HeadCount\Models\Occurrence;

class Kernel extends ConsoleKernel {
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule) {
        $schedule->call(function () {
            // Create Occurance
            $e = Event::find(1);
            $cron = CronExpression::factory($e->schedule);
            $occurrence = Occurrence::create([
                    'event_id'=>$e->id,
                    'start_time'=>$cron->getNextRunDate()->format('Y-m-d H:i:s')
            ]);


            Notification::send($e->users, new EventRsvp($occurrence));
        })->weekly()->mondays()->at('16:08');
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands() {
        require base_path('routes/console.php');
    }
}

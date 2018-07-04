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
            $e = Event::whereName("Elder's Quorum Basketball")->first();
            Artisan::call('occurrences:create', ['event_id' => $e->id]);
            $e->load('occurrences');
            Artisan::call('users:notify', ['occurrence_id' => $e->occurrences->last()->id]);
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

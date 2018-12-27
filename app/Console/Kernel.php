<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Telegram\Bot\Api;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();

        // $schedule->call(function () 
        // { 
        //     $this->TestTelegramBot(); 
        // })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

    private function TestTelegramBot()
    {
        $bot_apikey = '542520829:AAGVBs-ZXApVczq2l-2VNDEi8u4fte8ADyE';
        $tg_chatid = '-310388494';

        $telegram = new Api($bot_apikey);
        $response = $telegram->sendMessage([
            'chat_id' => $tg_chatid, 
            'text' => 'Dear team: Hello world.',
        ]);
    }
}

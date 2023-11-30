<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Batch;
use App\Jobs\SendReminderEmail;
use App\Models\Reservation;
use App\Mail\RemindMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminder';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $today = new Carbon();
        $date = $today->toDateString();

        $reservations = Reservation::with('user', 'shop')->where('date', $date)->get();

        if($reservations) {
            foreach( $reservations as $reservation) {
                $oldTime = strtotime($reservation->time);
                $time = date('H:i',$oldTime);
                $contents = [
                    'shop' => $reservation->shop->name,
                    'time' => $time,
                    'number' => $reservation->number,
                ];
                Mail::to($reservation->user->email)->send(new RemindMail($contents));
            }
        }
    }
}

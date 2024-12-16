<?php

namespace App\Jobs;

use App\Mail\Welcome;
use App\Mail\WelcomeMail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class sendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $emails;

    public function __construct($emails)
    {
        $this->emails = $emails;
    }

    public function handle()
    {
        try{
        for($i=0;$i<100;$i++) {
            Mail::to('test@yopmail.com')->send(new WelcomeMail('test@yopmail.com'));
        }
       } catch(\Exception $e) {
         \Log::info($e->getMessage());
       }
    }
}

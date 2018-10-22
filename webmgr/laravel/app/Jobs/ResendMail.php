<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Mail;

class ResendMail extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    private $emaillink = '';
    private $mailto = '';
    
    //--------------------------------------------------------

    public function __construct($emaillink, $mailto)
    {
        $this->emaillink = $emaillink;
        $this->mailto = $mailto;
    }

    public function handle()
    {
        Mail::send('email.emailactivated',
            ['emaillink' => $this->emaillink],
            function ($m) {
                $m->from(env('MAIL_FROM'), env('MAIL_NAME'));
                $m->to($this->mailto)->subject('【補】啟用帳號通知');
            });
    }   
}

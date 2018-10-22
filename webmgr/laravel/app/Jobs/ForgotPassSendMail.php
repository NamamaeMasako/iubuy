<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Mail;

class ForgotPassSendMail extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    private $tb_IUUsers = null;
    private $mailto = '';
    
    //--------------------------------------------------------

    public function __construct($tb_IUUsers, $mailto)
    {
        $this->tb_IUUsers = $tb_IUUsers;
        $this->mailto = $mailto;
    }

    public function handle()
    {
        Mail::send('email.forgotpass',
            ['tb_IUUsers' => $this->tb_IUUsers],
            function ($m) {
                $m->from(env('MAIL_FROM'), env('MAIL_NAME'));
                $m->to($this->mailto)->subject('忘記密碼通知');
            });
    }   
}

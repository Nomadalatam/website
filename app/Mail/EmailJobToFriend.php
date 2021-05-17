<?php

namespace App\Mail;

use App\Models\EmailJob;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailJobToFriend extends Mailable
{
    use Queueable, SerializesModels;

    /** @var EmailJob $emailJob */
    public $emailJob;

    /**
     * Create a new message instance.
     *
     * @param  EmailJob  $emailJob
     */
    public function __construct(EmailJob $emailJob)
    {
        $this->emailJob = $emailJob;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'))
            ->subject("Email for Job Details")
            ->markdown('emails.jobs.email_job');
    }
}

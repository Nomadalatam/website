<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class JobNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $jobs;
    public $candidateName;
    public $url;

    /**
     * JobNotification constructor.
     * @param $jobs
     * @param $candidateName
     */
    public function __construct($jobs, $candidateName)
    {
        $this->jobs = $jobs;
        $this->candidateName = $candidateName;
        $this->url = url('/');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'))
            ->subject("New Job Notification")->markdown('emails.jobs.notification');
    }
}

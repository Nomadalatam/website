<?php

namespace App\Mail;

use App\Models\Candidate;
use App\Models\Job;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailToEmployer extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Job $job
     */
    public $job;
    public $candidateUniqueId;

    /**
     * Create a new message instance.
     *
     * @param  Job  $job
     */
    public function __construct(Job $job)
    {
        $this->job = $job;
        $this->candidateUniqueId = Candidate::whereUserId(getLoggedInUserId())->value('unique_id');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'))
            ->subject("Job Applied by Candidate")->markdown('emails.jobs.email_employer');
    }
}

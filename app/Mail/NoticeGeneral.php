<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Supervisor;
use App\Application;

class NoticeGeneral extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Supervisor $supervisor,Application $application)
    {
        // dd($supervisor);
        $this->supervisor = $supervisor;
        $this->application = $application;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('example@example.com')
                // ->view('emails.notifysv');
                ->markdown('emails.noticeall')
                ->with([
                        'supervisor' => $this->supervisor,
                        'application' => $this->application
                    ]);
    }
}

<?php

namespace App\Mail;
use App\Supervisor;
use App\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifySupervisorHtml extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Supervisor $supervisor,Booking $booking)
    {
        // dd($supervisor);
        $this->supervisor = $supervisor;
        $this->booking = $booking;
        $plaintext = $supervisor->email;
        $this->ciphertext = base64_encode($plaintext.'/UTP');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('no-reply@kofixlabs.co')
                ->view('emails.notifysv_html')
                // ->markdown('emails.notifysv')
                ->with([
                        'supervisor' => $this->supervisor,
                        'booking' => $this->booking,
                        'token' => $this->ciphertext
                    ]);
    }
}

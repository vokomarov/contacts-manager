<?php

namespace App\Mail;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;

class ContactDeletedMail extends Mailable implements ShouldQueue
{
    use Queueable;

    /**
     * @var \App\Models\Contact
     */
    protected $contact;

    /**
     * Create a new message instance.
     *
     * @param \App\Models\Contact $contact
     */
    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))->markdown('emails.contact-deleted', [
            'contact' => $this->contact
        ]);
    }
}

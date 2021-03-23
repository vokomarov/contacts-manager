<?php

namespace App\Listeners;

use App\Events\ContactDeleted;
use App\Mail\ContactDeletedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendContactDeletedNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * The number of times the queued listener may be attempted.
     *
     * @var int
     */
    public $tries = 1;

    /**
     * Handle the event.
     *
     * @param  \App\Events\ContactDeleted  $event
     * @return void
     */
    public function handle(ContactDeleted $event)
    {
        foreach (config('contacts.notify-on-deleted', []) as $recipient) {
            Mail::to($recipient)->send(new ContactDeletedMail($event->contact));
        }
    }
}

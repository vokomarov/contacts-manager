<?php

namespace Tests\Unit;

use App\Events\ContactDeleted;
use App\Mail\ContactDeletedMail;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactDeletedTest extends TestCase
{
    public function testEventDispatched()
    {
        Event::fake();

        $owner = User::factory()->create();

        $contact = Contact::factory()->create([
            'owner_id' => $owner->id,
        ]);

        $contact->delete();

        Event::assertDispatched(function (ContactDeleted $event) use ($contact) {
            return $event->contact->id === $contact->id;
        });
    }

    public function testMailQueued()
    {
        Mail::fake();

        $owner = User::factory()->create();

        $contact = Contact::factory()->create([
            'owner_id' => $owner->id,
        ]);

        $contact->delete();

        Mail::assertQueued(function (ContactDeletedMail $mail) use ($contact) {
            return $mail->contact->id === $contact->id;
        });
    }
}

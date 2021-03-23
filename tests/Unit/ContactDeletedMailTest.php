<?php

namespace Tests\Unit;

use App\Mail\ContactDeletedMail;
use App\Models\Contact;
use Tests\TestCase;

class ContactDeletedMailTest extends TestCase
{
    public function testSeeContact()
    {
        $contact = Contact::factory()->make();

        $mailable = new ContactDeletedMail($contact);

        $mailable->assertSeeInHtml($contact->name);
        $mailable->assertSeeInText($contact->name);

        $mailable->assertSeeInHtml($contact->email);
        $mailable->assertSeeInText($contact->email);
    }
}

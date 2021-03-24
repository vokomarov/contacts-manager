<?php

namespace Tests\Feature;

use App\Events\ContactDeleted;
use App\Models\Contact;
use App\Models\User;
use Bouncer;
use Illuminate\Foundation\Testing\Concerns\InteractsWithDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class ContactsAPITest extends TestCase
{
    use InteractsWithDatabase, DatabaseTransactions;

    protected function createContact()
    {
        $owner = User::factory()->create();

        return Contact::factory()->create([
            'owner_id' => $owner->id,
        ]);
    }

    protected function getAuthHeaders(string $role = null, &$user = null): array
    {
        if ($user === null) {
            $user = User::factory()->create();
        }

        $token = $user->createToken(random_int(100, 999))->plainTextToken;

        Bouncer::dontCache();

        Bouncer::assign($role ?? 'reader')->to($user);

        return [
            'Authorization' => 'Bearer ' . $token
        ];
    }

    public function testList()
    {
        $contact = $this->createContact();

        $response = $this->json(Request::METHOD_GET, '/api/contacts', [], $this->getAuthHeaders());

        $response->assertOk();

        $response->assertJsonFragment([
            'id' => $contact->id,
            'name' => $contact->name,
            'email' => $contact->email,
        ]);
    }

    public function testGet()
    {
        $contact = $this->createContact();

        $response = $this->json(Request::METHOD_GET, "/api/contacts/{$contact->id}", [], $this->getAuthHeaders());

        $response->assertOk();

        $response->assertJsonFragment([
            'id' => $contact->id,
            'name' => $contact->name,
            'email' => $contact->email,
        ]);
    }

    public function testCreate()
    {
        $contact = Contact::factory()->make();

        $body = [
            'name' => $contact->name,
            'lastname' => $contact->lastname,
            'email' => $contact->email,
            'company_name' => $contact->company_name,
            'company_job_title' => $contact->company_job_title,
        ];

        $user = null;

        $response = $this->json(Request::METHOD_POST, '/api/contacts', $body, $this->getAuthHeaders(null, $user));

        $response->assertStatus(Response::HTTP_FORBIDDEN);

        $response = $this->json(Request::METHOD_POST, '/api/contacts', $body, $this->getAuthHeaders('moderator', $user));

        $response->assertStatus(Response::HTTP_CREATED);

        $response->assertJsonFragment($body);

        $this->assertDatabaseHas('contacts', [
            'name' => $contact->name,
            'lastname' => $contact->lastname,
            'email' => $contact->email,
        ]);
    }

    public function testUpdate()
    {
        $contact = $this->createContact();

        $newContact = Contact::factory()->make();

        $body = [
            'name' => $newContact->name,
            'lastname' => $newContact->lastname,
            'email' => $newContact->email,
            'company_name' => $newContact->company_name,
            'company_job_title' => $newContact->company_job_title,
        ];

        $user = null;

        $response = $this->json(Request::METHOD_PATCH, "/api/contacts/{$contact->id}", $body, $this->getAuthHeaders(null, $user));

        $response->assertStatus(Response::HTTP_FORBIDDEN);

        $response = $this->json(Request::METHOD_PATCH, "/api/contacts/{$contact->id}", $body, $this->getAuthHeaders('moderator', $user));

        $response->assertStatus(Response::HTTP_FORBIDDEN);

        $response = $this->json(Request::METHOD_PATCH, "/api/contacts/{$contact->id}", $body, $this->getAuthHeaders('admin', $user));

        $response->assertOk();

        $response->assertJsonFragment([
            'name' => $newContact->name,
            'lastname' => $newContact->lastname,
            'email' => $newContact->email,
            'company_name' => $newContact->company_name,
            'company_job_title' => $newContact->company_job_title,
        ]);

        $this->assertDatabaseHas('contacts', [
            'id' => $contact->id,
            'name' => $newContact->name,
            'lastname' => $newContact->lastname,
            'email' => $newContact->email,
        ]);

        $this->assertDatabaseMissing('contacts', [
            'id' => $contact->id,
            'name' => $contact->name,
            'lastname' => $contact->lastname,
            'email' => $contact->email,
        ]);
    }

    public function testDelete()
    {
        Event::fake();

        $contact = $this->createContact();

        $user = null;

        $response = $this->json(Request::METHOD_DELETE, "/api/contacts/{$contact->id}", [], $this->getAuthHeaders(null, $user));

        $response->assertStatus(Response::HTTP_FORBIDDEN);

        $response = $this->json(Request::METHOD_DELETE, "/api/contacts/{$contact->id}", [], $this->getAuthHeaders('moderator', $user));

        $response->assertStatus(Response::HTTP_FORBIDDEN);

        $response = $this->json(Request::METHOD_DELETE, "/api/contacts/{$contact->id}", [], $this->getAuthHeaders('admin', $user));

        $response->assertOk();

        Event::assertDispatched(function (ContactDeleted $event) use ($contact) {
            return $event->contact->id === $contact->id;
        });

        $this->assertDatabaseMissing('contacts', [
            'id' => $contact->id,
        ]);
    }
}

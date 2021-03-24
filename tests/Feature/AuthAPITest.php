<?php

namespace Tests\Feature;

use App\Models\User;
use Bouncer;
use Illuminate\Foundation\Testing\Concerns\InteractsWithDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthAPITest extends TestCase
{
    use DatabaseTransactions, InteractsWithDatabase;

    protected function getAuthHeaders(): array
    {
        $user = User::factory()->create();

        return [
            'Authorization' => 'Bearer ' . $user->createToken('test')->plainTextToken
        ];
    }

    public function testLogin()
    {
        $user = User::factory()->create([
            'password' => Hash::make('secret'),
        ]);

        Bouncer::assign('reader')->to($user);

        $response = $this->json(Request::METHOD_POST, '/api/auth/login', [
            'email' => $user->email,
            'password' => 'wrong-secret',
        ]);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);

        $response = $this->json(Request::METHOD_POST, '/api/auth/login', [
            'email' => $user->email,
            'password' => 'secret',
        ]);

        $response->assertOk();

        $response->assertJsonStructure(['token']);

        $token = $response->json('token');

        $this->assertNotEmpty($token);

        $response = $this->json(Request::METHOD_GET, '/api/contacts', [], [
            'Authorization' => "Bearer {$token}",
        ]);

        $response->assertOk();
    }
}

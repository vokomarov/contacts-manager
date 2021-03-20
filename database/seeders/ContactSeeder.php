<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::where('email', env('ADMIN_EMAIL'))->first();

        if (! $admin instanceof User) {
            throw new \ErrorException('Admin user not found. Please run migration.');
        }

        Contact::factory()->count(rand(120, 150))->create([
            'owner_id' => $admin->id,
        ]);
    }
}

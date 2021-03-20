<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Migrations\Migration;

class CreateInitialUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $admin = new User([
            'name' => 'Admin',
            'email' => env('ADMIN_EMAIL', 'admin@contact-manager.localhost'),
        ]);

        $admin->password = Hash::make(env('ADMIN_PASSWORD', 'secret'));
        $admin->email_verified_at = now();

        $admin->save();
    }
}

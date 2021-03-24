<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Hash;

class CreateInitialRolesAndPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create roles and permissions
        Bouncer::allow('admin')->to('read-contacts');
        Bouncer::allow('admin')->to('create-contacts');
        Bouncer::allow('admin')->to('update-contacts');
        Bouncer::allow('admin')->to('delete-contacts');
        Bouncer::allow('moderator')->to('read-contacts');
        Bouncer::allow('moderator')->to('create-contacts');
        Bouncer::allow('reader')->to('read-contacts');

        // Fill default roles to a users and admin role to an initial user
        $adminEmail = env('ADMIN_EMAIL');
        foreach (User::all() as $user) {
            if ($user->email === $adminEmail) {
                Bouncer::assign('admin')->to($user);
                continue;
            }

            Bouncer::assign('reader')->to($user);
        }

        // Create one moderator
        $moderator = new User([
            'name' => 'Moderator',
            'email' => 'moderator@contact-manager.localhost',
        ]);

        $moderator->password = Hash::make('secret');
        $moderator->email_verified_at = now();
        $moderator->save();

        Bouncer::assign('moderator')->to($moderator);
    }
}

<?php

use Illuminate\Database\Seeder;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // insert user with admin role
        User::create([
              'name' => 'admin',
              'email' => 'admin@mail.com',
              'password' => bcrypt('katakunci'),
              'email_verified_at' => now(),
              'role' => 'admin',
        ]);
        
        // insert user again with user role
        User::create([
            'name' => 'user',
            'email' => 'user@mail.com',
            'password' => bcrypt('katakunci'),
            'email_verified_at' => now(),
            'role' => 'user',
        ]);
    }
}

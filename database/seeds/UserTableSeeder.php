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
        try {
            foreach ($this->items() as $item) {
                User::updateOrCreate($item);
            }
        } catch (Exception $e) {
            throw $e;
        }
    }
    public function items(): array
    {
        return [
            // insert user with admin role
            [
                  'name' => 'admin',
                  'email' => 'admin@mail.com',
                  'password' => bcrypt('katakunci'),
                  'email_verified_at' => now(),
                  'role' => 'admin',
            ],
            // insert user again with user role
            [
                'name' => 'user',
                'email' => 'user@mail.com',
                'password' => bcrypt('katakunci'),
                'email_verified_at' => now(),
                'role' => 'user',
            ]
        ];
    }
}

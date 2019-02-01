<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('role', ['admin', 'user'])->default('user');
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('users')->insert([
          [
            'name' => 'admin',
            'email' => 'admin@mail.com',
            'password' => bcrypt('katakunci'),
            'email_verified_at' => date('Y-m-d G:i:s'),
            'role' => 'admin',
          ],
          [
            'name' => 'user',
            'email' => 'user@mail.com',
            'password' => bcrypt('katakunci'),
            'email_verified_at' => NULL,
            'role' => 'user',

          ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}

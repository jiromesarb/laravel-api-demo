<?php

use Illuminate\Database\Seeder;

class userTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create Default User
        App\User::create([
            'name' => 'Sample Account',
            'email' => 'sample@sample.com',
            'password' => bcrypt('Password123'),
            'user_role' => 1,
            'default_password' => 1,
            'remember_token' => Str::random(10),
        ]);

        // Create Sample Users
        factory(App\User::class, 10)->create();
    }
}

<?php

use Illuminate\Database\Seeder;

class rolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Set Default User Roles
        $roles = [
            [
                'name' => 'admin',
                'description' => 'Can access all modules',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'employee',
                'description' => 'Can access Student Management with restrictions',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        // Create Default User
        App\Role::insert($roles);
    }
}

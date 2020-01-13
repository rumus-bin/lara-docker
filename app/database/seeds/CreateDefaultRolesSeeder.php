<?php

use Illuminate\Database\Seeder;

class CreateDefaultRolesSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Role::create(['title' => 'user']);
        \App\Models\Role::create(['title' => 'admin']);
    }
}

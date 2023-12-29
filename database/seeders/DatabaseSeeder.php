<?php

namespace Database\Seeders;

use App\Models\Test;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(RolePermissionSeeder::class);
        // $this->call(UserSeeder::class);
        Test::factory(200)->create();
        
        // \App\Models\User::factory(1)->create();
        
    }
}

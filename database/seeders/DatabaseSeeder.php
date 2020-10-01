<?php

namespace Database\Seeders;

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
        \App\Models\User::factory()->count(10)->create();
        // User::factory(10)->create();
        $this->call(ProductSeeder::class);
        $this->call(CategorySeeder::class);
        // $this->call(UserSeeder::class);
    }
}

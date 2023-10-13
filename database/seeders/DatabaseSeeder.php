<?php

namespace Database\Seeders;

use App\Models\User;
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
        User::factory()->create([
            'name' => 'Luis Felipe',
            'email' => 'siulacio@hotmail.com',
            'password' => bcrypt('12345678'),
        ]);
    }
}

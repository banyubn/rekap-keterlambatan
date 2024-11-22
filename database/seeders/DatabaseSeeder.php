<?php

namespace Database\Seeders;

use App\Models\Rayon;
use App\Models\Rombel;
use App\Models\Student;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory()->create([
        //     'name' => 'Bagastara',
        //     'email' => 'farrel@gmail.com',
        //     'role' => 'admin',
        //     'password' => Hash::make('password'),
        // ]);

        // User::factory()->create([
        //     'name' => 'Ranny Febriana',
        //     'email' => 'ranny@gmail.com',
        //     'role' => 'ps',
        //     'password' => Hash::make('password'),
        // ]);
        
        // Rayon::create([
        //     'rayon' => 'Sukasari 1',
        //     'user_id' => '9d4b5f46-39bd-4701-984a-059cdaf507cc'
        // ]);

        // Rombel::create([
        //     'rombel' => 'PPLG XI-5'
        // ]);

        // $faker = Faker::create();

        // for ($i = 0; $i < 15; $i++) {
        //     Student::create([
        //         'nis' => '12' . $faker->unique()->numberBetween(100000, 999999),
        //         'name' => $faker->name,
        //         'rombel_id' => 1,
        //         'rayon_id' => 2
        //     ]);
        // }
    }
}

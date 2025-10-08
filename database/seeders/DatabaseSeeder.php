<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        /* User::factory()->create([
            'username' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('secret'),
            'name' => 'test@example.com',
            'lastname' => 'test@example.com',
            'is_admin' => 'test@example.com',
        ]); */

        // call seeder
        $this->call([
            //VocabSeeder::class,      // <-- nuestro seeder de vocabularios
            UsersTableSeeder::class,
            /* TaxonAllInOneSeeder::class, */
        ]);


    }
}

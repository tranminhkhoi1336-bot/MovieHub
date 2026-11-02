

<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Nap hai lop Seeder
        require_once __DIR__ . '/MoviesTableSeeder.php';
        require_once __DIR__ . '/ShowtimesTableSeeder.php';

        // Chay Seeder theo thu tu
        $this->call([
            MoviesTableSeeder::class,
            ShowtimesTableSeeder::class,
        ]);
    }
}


<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShowtimesTableSeeder extends Seeder
{
    public function run()
    {
        $showtimes = [
            [
                'title' => 'Avatar 3: Lửa Và Tro Tàn (Avatar: Fire and Ash)',
                'starts_at' => '2026-10-26 08:00:00',
            ],
            [
                'title' => 'Avengers: Endgame (Avengers: Hồi Kết)',
                'starts_at' => '2026-10-26 11:30:00',
            ],
            [
                'title' => 'Nhà bà Nữ',
                'starts_at' => '2026-10-26 15:00:00',
            ],
            [
                'title' => 'Mai',
                'starts_at' => '2026-10-26 18:00:00',
            ],
        ];

        foreach ($showtimes as $showtime) {

            $movieId = DB::table('movies')
                ->where('title', $showtime['title'])
                ->value('id');

            if (!$movieId) {
                continue;
            }

            $exists = DB::table('showtimes')
                ->where('movie_id', $movieId)
                ->where('starts_at', $showtime['starts_at'])
                ->exists();

            if (!$exists) {
                DB::table('showtimes')->insert([
                    'movie_id' => $movieId,
                    'starts_at' => $showtime['starts_at'],
                    'price' => 90000,
                    'total_seats' => 50,
                    'status' => 'scheduled',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}


<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MoviesTableSeeder extends Seeder
{
    public function run()
    {
        $movies = [
            [
                'title' => 'Avatar 3: Lửa Và Tro Tàn (Avatar: Fire and Ash)',
                'description' => 'Gia đình Jake Sully tiếp tục hành trình trên Pandora và phải đối mặt với những mối đe dọa mới.',
                'genre' => 'Hành động, Phiêu lưu, Khoa học viễn tưởng',
                'duration' => 197,
                'release_date' => '2025-12-19',
                'poster' => null,
                'status' => 'now_showing',
            ],
            [
                'title' => 'Avengers: Endgame (Avengers: Hồi Kết)',
                'description' => 'Các siêu anh hùng còn sống tập hợp để thực hiện nhiệm vụ cuối cùng nhằm khôi phục vũ trụ.',
                'genre' => 'Hành động, Phiêu lưu, Khoa học viễn tưởng',
                'duration' => 181,
                'release_date' => '2019-04-26',
                'poster' => null,
                'status' => 'now_showing',
            ],
            [
                'title' => 'Mai',
                'description' => 'Câu chuyện về người phụ nữ tên Mai và hành trình tìm kiếm tình yêu, hạnh phúc.',
                'genre' => 'Tâm lý, Tình cảm',
                'duration' => 131,
                'release_date' => '2024-02-10',
                'poster' => null,
                'status' => 'now_showing',
            ],
            [
                'title' => 'Nhà bà Nữ',
                'description' => 'Những mâu thuẫn và tình cảm giữa các thành viên trong gia đình bà Nữ.',
                'genre' => 'Gia đình, Hài, Tâm lý',
                'duration' => 102,
                'release_date' => '2023-01-22',
                'poster' => null,
                'status' => 'now_showing',
            ],
        ];

        foreach ($movies as $movie) {
            $exists = DB::table('movies')
                ->where('title', $movie['title'])
                ->exists();

            if (!$exists) {
                DB::table('movies')->insert(
                    array_merge($movie, [
                        'created_at' => now(),
                        'updated_at' => now(),
                    ])
                );
            }
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Banner::insert([
            [
                'id' => 1,
                'title' => 'Lorem ipsum is placeholder text commonly used in the graphic, print, mockups.',
                'description' => 'Lorem ipsum is placeholder text commonly used in the graphic, print, mockups.',
                'image' => 'hero-img.png',
                'status' => 1,
                'added_by' => 1,
                'created_at' => '2024-07-27 02:33:41',
                'updated_at' => '2024-07-27 02:34:20',
            ],
            [
                'id' => 2,
                'title' => 'Lorem ipsum is placeholder text commonly used in the graphic, print, mockups',
                'description' => 'Lorem ipsum is placeholder text commonly used in the graphic, print, mockups.',
                'image' => 'hero-img.png',
                'status' => 1,
                'added_by' => 1,
                'created_at' => '2024-07-27 02:34:15',
                'updated_at' => '2024-07-27 02:34:17',
            ],
        ]);
    }
}

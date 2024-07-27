<?php

namespace Database\Seeders;

use App\Models\MainContent;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MainContentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MainContent::insert([
            [
                'id' => 1,
                'name' => 'name',
                'content' => 'Ingo Forum',
                'media' => null,
                'url' => null,
                'visibility' => 0,
                'created_at' => '2024-07-27 01:12:24',
                'updated_at' => '2024-07-27 01:12:24',
            ],
            [
                'id' => 2,
                'name' => 'short_content',
                'content' => 'The INGO Forum is a platform for International Non-Governmental Organizations (INGOs) working in Bangladesh. Established in response to the evolving needs of the development sector',
                'media' => null,
                'url' => null,
                'visibility' => 0,
                'created_at' => '2024-07-27 01:12:24',
                'updated_at' => '2024-07-27 01:12:24',
            ],
            [
                'id' => 3,
                'name' => 'address',
                'content' => 'Shekertek 10 Mohammadpur',
                'media' => null,
                'url' => null,
                'visibility' => 0,
                'created_at' => '2024-07-27 01:12:24',
                'updated_at' => '2024-07-27 01:12:24',
            ],
            [
                'id' => 4,
                'name' => 'email',
                'content' => 'alkafirupam1@gmail.com',
                'media' => null,
                'url' => null,
                'visibility' => 0,
                'created_at' => '2024-07-27 01:12:24',
                'updated_at' => '2024-07-27 01:12:24',
            ],
            [
                'id' => 5,
                'name' => 'phone',
                'content' => '01719022853',
                'media' => null,
                'url' => null,
                'visibility' => 0,
                'created_at' => '2024-07-27 01:12:24',
                'updated_at' => '2024-07-27 01:12:24',
            ],
            [
                'id' => 6,
                'name' => 'facebook',
                'content' => 'https://www.facebook.com/',
                'media' => null,
                'url' => null,
                'visibility' => 0,
                'created_at' => '2024-07-27 01:12:24',
                'updated_at' => '2024-07-27 01:40:58',
            ],
            [
                'id' => 7,
                'name' => 'linkedin',
                'content' => 'https://www.linkedin.com/',
                'media' => null,
                'url' => null,
                'visibility' => 0,
                'created_at' => '2024-07-27 01:12:24',
                'updated_at' => '2024-07-27 01:40:58',
            ],
            [
                'id' => 8,
                'name' => 'youtube',
                'content' => 'https://www.youtube.com/',
                'media' => null,
                'url' => null,
                'visibility' => 0,
                'created_at' => '2024-07-27 01:12:24',
                'updated_at' => '2024-07-27 01:40:58',
            ],
            [
                'id' => 9,
                'name' => 'twitter',
                'content' => 'https://www.x.com/',
                'media' => null,
                'url' => null,
                'visibility' => 0,
                'created_at' => '2024-07-27 01:12:24',
                'updated_at' => '2024-07-27 01:40:58',
            ],
            [
                'id' => 11,
                'name' => 'aboutus-content',
                'content' => json_encode([
                    'content' => [
                        'title' => 'What is INGO Forum',
                        'slogan' => 'The INGO Forum is a platform for International Non-Governmental Organizations (INGOs) working in Bangladesh',
                        'description' => '<p>The INGO Forum is a platform for International Non-Governmental Organizations (INGOs) working in Bangladesh. Established in response to the evolving needs of the development sector, the forum&#39;s mission is to:</p><ul><li>Facilitate information exchange and collaboration among INGOs to improve their practices and jointly influence development efforts.</li><li>Work towards maximizing impact through collaborative approaches and establishing common ground on best practices.</li><li>Engage with the Government of Bangladesh on issues concerning INGOs.</li><li>Promote transparency, accountability, and adherence to the SDGs in the work of INGOs within Bangladesh.</li></ul>',
                        'status' => 0,
                    ],
                ]),
                'media' => null,
                'url' => null,
                'visibility' => 0,
                'created_at' => '2024-07-27 01:35:06',
                'updated_at' => '2024-07-27 01:38:26',
            ],
        ]);
    }
}

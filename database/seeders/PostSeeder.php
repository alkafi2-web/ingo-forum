<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostSubCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Seed the post_categories table
        PostCategory::insert([
            [
                'id' => 1,
                'name' => 'News',
                'slug' => 'news',
                'status' => 1,
                'created_at' => '2024-07-27 02:03:32',
                'updated_at' => '2024-07-27 02:03:32',
            ],
            [
                'id' => 2,
                'name' => 'Blog',
                'slug' => 'blog',
                'status' => 1,
                'created_at' => '2024-07-27 02:03:36',
                'updated_at' => '2024-07-27 02:03:36',
            ],
        ]);

        // Seed the post_sub_categories table
        PostSubCategory::insert([
            [
                'id' => 1,
                'category_id' => 1,
                'name' => 'Unauthorized',
                'slug' => 'unauthorized',
                'status' => 0,
                'created_at' => '2024-07-27 02:03:43',
                'updated_at' => '2024-07-27 02:03:43',
            ],
            [
                'id' => 2,
                'category_id' => 2,
                'name' => 'Unauthorized',
                'slug' => 'unauthorized',
                'status' => 0,
                'created_at' => '2024-07-27 02:03:49',
                'updated_at' => '2024-07-27 02:03:49',
            ],
        ]);

        // Seed the posts table
        Post::insert([
            [
                'id' => 1,
                'category_id' => 1,
                'sub_category_id' => 1,
                'title' => 'DEMO',
                'slug' => 'demo',
                'short_des' => '<p>Demo Post</p>',
                'long_des' => '<p>Demo Post</p>',
                'banner' => 'blog.png',
                'status' => 1,
                'added_by' => 1,
                'seo' => null,
                'og' => null,
                'created_at' => '2024-07-27 02:05:47',
                'updated_at' => '2024-07-27 02:05:51',
            ],
            [
                'id' => 2,
                'category_id' => 2,
                'sub_category_id' => 2,
                'title' => 'DEMO',
                'slug' => 'demo',
                'short_des' => '<p>Demo Post</p>',
                'long_des' => '<p>Demo Post</p>',
                'banner' => 'blog.png',
                'status' => 1,
                'added_by' => 1,
                'seo' => null,
                'og' => null,
                'created_at' => '2024-07-27 02:05:47',
                'updated_at' => '2024-07-27 02:05:51',
            ],
            [
                'id' => 3,
                'category_id' => 2,
                'sub_category_id' => 2,
                'title' => 'DEMO',
                'slug' => 'demo',
                'short_des' => '<p>Demo Post</p>',
                'long_des' => '<p>Demo Post</p>',
                'banner' => 'blog.png',
                'status' => 1,
                'added_by' => 1,
                'seo' => null,
                'og' => null,
                'created_at' => '2024-07-27 02:05:47',
                'updated_at' => '2024-07-27 02:05:51',
            ],
        ]);
    }
}

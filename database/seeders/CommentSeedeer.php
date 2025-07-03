<?php

namespace Database\Seeders;

use App\Models\Comment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeedeer extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Comment::factory(5)->create([
            'user_id' => 1, // Assuming user with ID 1 exists
            'post_id' => 2, // Assuming post with ID 1 exists
        ]);
    }
}

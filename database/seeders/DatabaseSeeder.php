<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Comment;
use App\Models\Phone;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $userIds = [];
        // user
        User::factory(8)->create()->each(function ($user) use (&$userIds) {
            Phone::factory(1)->addRelationship($user->id, $user->uuid)->create();
            $userIds[] = $user->id;
        });
        shuffle($userIds);

        User::factory(2)->vip()->create()->each(function ($user) use (&$userIds) {
            Phone::factory(1)->addRelationship($user->id, $user->uuid)->create();
            array_unshift($userIds, $user->id);
        });

        // post
        // user Null 的 post id = 3
        $times = count($userIds) - 3;
        for ($i = 1; $i <= $times; $i++) {
            $userId = $i == 3 ? null : array_shift($userIds);
            Post::factory(1)->assignUser($userId)->create()->each(function ($post) {
                $amount = rand(1, 3);
                Comment::factory($amount)->addRelationship($post->id, $post->uuid)->create();
                Comment::factory($amount)->addRelationship($post->id, $post->uuid)->specificTitle('foo')->create();
            });
        }


        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}

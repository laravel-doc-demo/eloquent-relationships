<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Comment;
use App\Models\Order;
use App\Models\Phone;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    private $userIds = [];

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

        $this->setUserIds($userIds);

        $this->generatePostAndComment();
        $this->generateOrder();
    }

    private function generatePostAndComment()
    {
        $userIds = $this->getUserIds();
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
    }

    private function generateOrder()
    {
//        $userIds = $this->getUserIds();
//        $times = count($userIds) - 3;
//
//        for ($i = 1;$i <= $times; $i++) {
//            shuffle($userIds);
//            // order
//            Order::factory(rand(1,5))->addRelationship(array_shift($userIds))->create();
//        }

        Order::factory(5)->addRelationship(1)->create();
    }

    /**
     * @return array
     */
    public function getUserIds(): array
    {
        return $this->userIds;
    }

    /**
     * @param array $userIds
     */
    public function setUserIds(array $userIds): void
    {
        $this->userIds = $userIds;
    }
}

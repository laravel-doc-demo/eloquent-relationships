<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Car;
use App\Models\Comment;
use App\Models\Deployment;
use App\Models\Environment;
use App\Models\Mechanic;
use App\Models\Order;
use App\Models\Owner;
use App\Models\Phone;
use App\Models\Post;
use App\Models\Project;
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
        $this->generateCarOwnerMechanics();
        $this->generateProject();
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

    private function generateCarOwnerMechanics()
    {
        $mechanicIds = Mechanic::factory(10)->create()->pluck('id')->toArray();

        shuffle($mechanicIds);
        $carIds = [];
        foreach ($mechanicIds as $id) {
            $carIds[] = Car::factory(1)->assignMechanic($id)->create()->first()->id;
        }

        shuffle($carIds);
        foreach ($carIds as $id) {
            Owner::factory(1)->assignCar($id)->create();
        }
    }

    private function generateProject()
    {
        $amount = 3;
        $projSuffix = 'A';
        $projIds = [];
        for ($i = 0; $i < $amount; $i++) {
            $projName = 'proj-' . $projSuffix;
            $projIds[] = Project::factory(1)->specificName($projName)->create()->first()->id;
            $projSuffix = str_increment($projSuffix);
        }

        $names = [
            'Development',
            'Staging',
            'Production',
            'Testing',
        ];
        foreach ($projIds as $projId) {
            $times = rand(1,4);
            for ($i = 0; $i < $times; $i++){
                Environment::factory(1)
                    ->assignProjectId($projId)
                    ->specificName($names[$i])
                    ->create()
                    ->each(function ($env) use ($times) {
                        Deployment::factory($times)->assignEnvironmentId($env->id)->create();
                    });
            }
        }
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

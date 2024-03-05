<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Car;
use App\Models\Comment;
use App\Models\Deployment;
use App\Models\Environment;
use App\Models\Image;
use App\Models\Mechanic;
use App\Models\Order;
use App\Models\Owner;
use App\Models\Phone;
use App\Models\Podcast;
use App\Models\PodcastUser;
use App\Models\Post;
use App\Models\Project;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    private array $userIds = [];

    private array $postIds = [];

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
        $this->generateRole();
        $this->generatePodcast();
        $this->generateImage();
    }

    private function generatePostAndComment()
    {
        $userIds = $this->getUserIds();
        // post
        // user Null 的 post id = 3
        $times = count($userIds) - 3;
        $postIds = [];
        for ($i = 1; $i <= $times; $i++) {
            $userId = $i == 3 ? null : array_shift($userIds);
            Post::factory(1)->assignUser($userId)->create()->each(function ($post) use (&$postIds) {
                $amount = rand(1, 3);
                Comment::factory($amount)->addRelationship($post->id, $post->uuid)->create();
                Comment::factory($amount)->addRelationship($post->id, $post->uuid)->specificTitle('foo')->create();
                $postIds[] = $post->id;
            });
        }

        $this->setPostIds($postIds);
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
            $times = rand(1, 4);
            for ($i = 0; $i < $times; $i++) {
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

    private function generateRole()
    {
        $roles = [
            'Admin',
            'Guest',
            'Editor',
            'User'
        ];
        foreach ($roles as $role) {
            Role::factory(1)->specificName($role)->create();
        }

        $rolesIds = [1, 2, 3, 4];
        $userIds = $this->getUserIds();
        foreach ($userIds as $id) {
            shuffle($rolesIds);
            $times = rand(1, 4);
            for ($i = 0; $i < $times; $i++) {
                RoleUser::factory(1)
                    ->buildRelationship($id)
                    ->buildRelationship($rolesIds[$i], 'role_id')
                    ->create();
            }
        }
    }

    private function generatePodcast()
    {
        $userIds = $this->getUserIds();

        $podcastIds = Podcast::factory(5)->create()->pluck('id')->toArray();

        foreach ($userIds as $userId) {
            shuffle($podcastIds);
            $times = rand(1, 4);
            for ($i = 0; $i < $times; $i++) {
                PodcastUser::factory(1)
                    ->buildRelationship($userId)
                    ->buildRelationship($podcastIds[$i], 'podcast_id')
                    ->create();
            }
        }
    }

    public function generateImage()
    {
        $data = [];
        foreach ($this->getUserIds() as $id) {
            $data[] = [
                'id' => $id,
                'model' => 'user'
            ];
        }

        foreach ($this->getPostIds() as $id) {
            $data[] = [
                'id' => $id,
                'model' => 'post'
            ];
        }

        shuffle($data);
        foreach ($data as $item) {
            Image::factory(1)
                ->url($item['model'])
                ->setIdModel($item['id'], ucfirst($item['model']))
                ->create();
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

    /**
     * @return array
     */
    public function getPostIds(): array
    {
        return $this->postIds;
    }

    /**
     * @param array $postIds
     */
    public function setPostIds(array $postIds): void
    {
        $this->postIds = $postIds;
    }
}

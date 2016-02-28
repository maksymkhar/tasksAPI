<?php

use App\Tag;
use App\Task;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call(UserTableSeeder::class);

        $faker = Faker\Factory::create();

        $this->seedTasks($faker);
        $this->seedTags($faker);
        $this->seedUsers();

        Model::reguard();
    }

    private function seedTasks($faker)
    {
        foreach (range(0,100) as $number)
        {
            $task = new Task();
            $task->name = $faker->sentence;
            $task->done = $faker->boolean;
            $task->priority = $faker->randomDigit;

            $task->save();
        }
    }

    private function seedTags($faker)
    {
        foreach (range(0,100) as $number)
        {
            $tag = new Tag();
            $tag->title = $faker->word;
            //$tag->active = $faker->boolean;

            $tag->save();
        }
    }

    private function seedUsers()
    {
        $user = new User();
        $user->name = "admin";
        $user->email = "admin@mail.com";
        $user->password = bcrypt(env('PASSWORD_ADMIN', 'admin'));

        $user->save();
    }
}

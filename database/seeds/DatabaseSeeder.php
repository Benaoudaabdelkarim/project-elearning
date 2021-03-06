<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(AdminSeeder::class);
        factory(App\User::class,10)->create();
        factory(App\Category::class,10)->create();
        factory(App\Post::class,10)->create();
        factory(App\Comment::class,10)->create();
        factory(App\Email::class,10)->create();
        factory(App\Slide::class,10)->create();
    }
}

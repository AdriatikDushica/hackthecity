<?php

use Illuminate\Database\Seeder;

class CommentsTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create('it');

        foreach(\App\Location::all() as $location) {
            for ($i = 0; $i < rand(1, 5); $i++) {
                \App\Comment::create([
                    'text' => $faker->sentence,
                    'user_id' => \App\User::all()->random()->id,
                    'location_id' => $location->id
                ]);
            }
        }

    }
}

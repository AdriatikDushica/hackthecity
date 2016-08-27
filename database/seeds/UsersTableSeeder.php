<?php

use App\Type;
use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create('it');

        for ($i = 0; $i < 100; $i++) {
            User::create([
                'name' => $faker->name,
                'email' => $faker->email
            ]);
        }

        $user = User::create([
            'name' => 'Adriatik Dushica',
            'email' => 'adriatik.dushica@gmail.com'
        ]);

        for ($i = 0; $i < 200; $i++) {
            $path = 'locations/' . $faker->md5 . '.jpg';
            \Storage::copy('demo/'.rand(1,5).'.jpg', $path);

            $user->locations()->create([
                'path' => $path,
                'lat' => $faker->randomFloat(8, 46.655792, 47.721267),
                'lng' => $faker->randomFloat(8, 6.480414, 10.342801),
                'disabled' => $faker->boolean,
                'description' => $faker->paragraph,
                'type_id' => Type::all()->random()->id
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as faker;

class DatabaseSeeder extends Seeder
{


    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        // \App\Models\User::factory(10)->create();
       /*  DB::table('subscriptions')->insert([
            'id'=> $this->faker->ean13,
            'server_id'=>$this->faker->randomNumber,
            'stripe_sid'=>$this->faker->regexify,
            'stripe_pid'=>$this->faker->regexify,
            'plan'=>$this->faker->randomNumber,
            'creation_date'=>$this->faker->dateTime,
            'join_date'=>$this->faker->dateTime

        ]);
        */
        \App\Database\Factories->call(SubscriptionsFactory::class);
    }
};

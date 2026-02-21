<?php

namespace Database\Factories;
use App\Models\Subscriptions;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class SubscriptionsFactory extends Factory
{

    /**
     *
     * @var string
     *
    */
    protected $model = \App\Models\SubscriptionsController::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [

                'id'=> $this->faker->ean13(11),
                'server_id'=>$this->$faker->randomNumber(11),
                'stripe_sid'=>$this->faker->regexify(20),
                'stripe_pid'=>$this->faker->regexify(20),
                'plan'=>$this->faker->randomNumber(11),
                'creation_date'=>$this->faker->now(),
                'join_date'=>$this->faker->dateTime
        ];
    }
}

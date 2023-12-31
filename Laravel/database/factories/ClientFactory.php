<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\ClientPlan;
use App\Models\ClientUser;
use App\Models\ConsumptionPlan;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $region  = ['SK', 'HU', 'CZ', 'AT'];
        return [
            'full_name' => $this->faker->firstName . $this->faker->lastName,
            "address" => $this->faker->address,
            "region" => $this->faker->randomElement($region),
            "teams_link" => $this->faker->url,
        ];
    }
    public function configure()
    {
        return $this->afterCreating(function (Client $client) {

            User::factory()->create([
                'user_name' => $client->full_name,
                'role_id' =>  Role::where('name', 'Admin')->first()->id
            ]);

            ClientUser::factory()
                ->count(random_int(5, 10))
                ->create([
                    'client_id' => $client->id,
                    'role_id' =>  Role::where('name', 'Manager')->first()->id
                ]);

            ClientPlan::factory()
                ->count(random_int(5, 10))
                ->create(
                    [
                        'client_id' => $client->id,
                    ]
                );

            // ConsumptionPlan::factory()
            //     ->count(random_int(10, 15))
            //     ->create([
            //         'client' => $client->full_name,
            //         'client_user' => $client->users->random()->full_name,
            //         'client_plan' => $client->plans->random()->short_name,
            //     ]);
        });
    }
}

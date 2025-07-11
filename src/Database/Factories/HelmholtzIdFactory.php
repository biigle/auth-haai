<?php

namespace Biigle\Modules\AuthHaai\Database\Factories;

use Biigle\Modules\AuthHaai\HelmholtzId;
use Biigle\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class HelmholtzIdFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = HelmholtzId::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => $this->faker->uuid(),
            'user_id' => User::factory(),
        ];
    }
}

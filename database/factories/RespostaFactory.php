<?php

namespace Database\Factories;

use App\Models\Resposta;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Questoe;

class RespostaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Resposta::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            return [
                'resposta' => $this->faker->name(),
                'questoe_id' => function() {
                    return Questoe::factory()->create()->id;
                },
            ];
        ];
    }
}

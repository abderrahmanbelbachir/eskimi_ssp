<?php

namespace Database\Factories;

use App\Models\Compaign;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompaignFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Compaign::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'from' => $this->faker->dateTimeBetween($startDate = '-30 years', $endDate = 'now', $timezone = null),
            'to' => $this->faker->dateTimeBetween($startDate = 'now', $endDate = '+30 years', $timezone = null),
            'total_budget' => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 700),
            'daily_budget' => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 70),
            'uploads' => json_encode(['https://firebasestorage.googleapis.com/v0/b/placetta-mobile.appspot.com/o/products%2F2117%2F1627163590126Placetta0?alt=media&token=ff76223f-0df3-4117-839d-6119a2c2ca57' ,
                'https://firebasestorage.googleapis.com/v0/b/placetta-mobile.appspot.com/o/products%2F2117%2F1627163590126Placetta0?alt=media&token=ff76223f-0df3-4117-839d-6119a2c2ca57']),
        ];
    }
}

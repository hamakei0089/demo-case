<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Stamp;
use App\Models\Rest;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class StampFactory extends Factory
{
    protected $model = Stamp::class;

    public function definition()
    {
        $workStart = $this->faker->dateTimeBetween('00:00:00', '23:00:00');
        $workEnd = (clone $workStart)->modify('+' . $this->faker->numberBetween(1, 1440 - (int)$workStart->format('i')) . ' minutes');

        return [
            'user_id' => \App\Models\User::factory(),
            'work_start' => $workStart,
            'work_end' => $workEnd,
        ];
    }
}
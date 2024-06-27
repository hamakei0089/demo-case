<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Rest;
use App\Models\Stamp;
use Carbon\Carbon;


class RestFactory extends Factory
{
protected $model = Rest::class;

    public function definition()
    {
        $stamp = \App\Models\Stamp::factory()->create();
        $workStart = $stamp->work_start;
        $workEnd = $stamp->work_end;

        $restStart = $this->faker->dateTimeBetween($workStart, $workEnd->modify('-90 minutes'));
        $restEnd = (clone $restStart)->modify('+' . $this->faker->numberBetween(1, 90) . ' minutes');

        if ($restEnd > $workEnd) {
            $restEnd = $workEnd;
        }

        return [
            'stamp_id' => $stamp->id,
            'rest_start' => $restStart,
            'rest_end' => $restEnd,
        ];
    }
}
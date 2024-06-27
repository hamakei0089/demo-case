<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Stamp;
use App\Models\Rest;
use Carbon\Carbon;


use Faker\Factory as FakerFactory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(20)->create()->each(function ($user) {
            $stamp = \App\Models\Stamp::factory()->create(['user_id' => $user->id]);

            $workStart = $stamp->work_start;
            $workEnd = $stamp->work_end;

            $restStart = \Faker\Factory::create()->dateTimeBetween($workStart, $workEnd->modify('-90 minutes'));
            $restEnd = (clone $restStart)->modify('+' . rand(1, 90) . ' minutes');

            if ($restEnd > $workEnd) {
                $restEnd = $workEnd;
            }

            \App\Models\Rest::factory()->create([
                'stamp_id' => $stamp->id,
                'rest_start' => $restStart,
                'rest_end' => $restEnd,
            ]);
        });
    }
}
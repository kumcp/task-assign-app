<?php

namespace Database\Factories;

use App\Models\Job;
use App\Models\JobAssign;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


class JobFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */

    protected $model = Job::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $workingDay = $this->faker->randomElement([2, 3, 4, 5]);
        $assignerId = $this->faker->randomElement([2, 3, 4, 5]);
        return [
            'code' => Str::random(10),
            'name' => $this->faker->word(),
            'assigner_id' => $assignerId,
            'parent_id'    => NULL,
            'job_type_id' => 0,
            'project_id' => 0,
            'priority_id' => 0,
            'deadline' => Carbon::now()->addDays($workingDay),
            'period' => $workingDay,
            'period_unit' => Job::PERIOD_UNIT_DAY,
            'lsx_amount' =>  NULL,
            'assign_amount' => NULL,
            'description' => $this->faker->sentence(),
        ];
    }
}

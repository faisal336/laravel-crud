<?php

namespace Database\Seeders;

use App\Models\Member;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        $noOfColumns = 15;
        $noOfRows = 500000;

        $range = range(1, $noOfRows);
        $chunkSize = 65535 / ($noOfColumns + 1);

        foreach (array_chunk($range, $chunkSize) as $chunk) {
            $user_data = [];

            foreach ($chunk as $i) {
                $num = rand(0, 1);
                $user_data[] = [
                    'first_name' => $faker->firstName(),
                    'last_name' => $faker->lastName(),
                    'email' => $faker->unique()->safeEmail(),
                    'info' => 'Favorite number: ' . $i . $num,
                    'is_active' => $num,
                ];
            }

            Member::insert($user_data);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 20; $i++) {
            DB::table('tasks')->insert([
                'title' => 'Task ' . $i,
                'description' => 'Some description ' . $i,
                'endDate' => now()->addDays($i),
                'completed' => rand(0, 1)
            ]);
        }
    }
}

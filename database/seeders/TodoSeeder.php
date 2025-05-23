<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Todo;
use Carbon\Carbon;

class TodoSeeder extends Seeder
{
    public function run(): void
    {
        $assignees = ['Alice', 'Bob', 'Charlie', 'David'];
        $statuses = ['pending', 'in_progress', 'completed'];
        $priorities = ['low', 'medium', 'high'];

        foreach (range(1, 20) as $i) {
            Todo::create([
                'title' => 'Todo Item ' . $i,
                'assignee' => $assignees[array_rand($assignees)],
                'due_date' => Carbon::now()->addDays(rand(-5, 10))->format('Y-m-d'),
                'time_tracked' => rand(1, 20) * 0.5, 
                'status' => $statuses[array_rand($statuses)],
                'priority' => $priorities[array_rand($priorities)],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

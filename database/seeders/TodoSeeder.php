<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Todo;
use Carbon\Carbon;

class TodoSeeder extends Seeder
{
    public function run(): void
    {
        $assignees = ['Kunto', 'Aji', 'David', 'Beckham'];
        $statuses = ['pending','open', 'in-progress', 'completed'];
        $priorities = ['low', 'medium', 'high'];

        foreach (range(1, 20) as $i) {
             $status = $statuses[array_rand($statuses)];
            Todo::create([
                'title' => 'Todo Item ' . $i,
                'assignee' => $assignees[array_rand($assignees)],
                'due_date' => Carbon::now()->addDays(rand(-5, 10))->format('Y-m-d'),
                'time_tracked' => $status === 'completed' ? rand(1, 20) * 0.5 : 0,
                'status' => $statuses[array_rand($statuses)],
                'priority' => $priorities[array_rand($priorities)],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

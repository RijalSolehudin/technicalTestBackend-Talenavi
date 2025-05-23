<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
   public function index(Request $request)
{
    $type = $request->query('type');

    if ($type === 'status') {
        $data = Todo::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');
        return response()->json(['status_summary' => $data]);
    }

    if ($type === 'priority') {
        $data = Todo::select('priority', DB::raw('count(*) as total'))
            ->groupBy('priority')
            ->pluck('total', 'priority');
        return response()->json(['priority_summary' => $data]);
    }

    if ($type === 'assignee') {
        $assignees = Todo::select('assignee')
            ->distinct()->pluck('assignee');

        $result = [];
        foreach ($assignees as $assignee) {
            $todos = Todo::where('assignee', $assignee);
            $result[$assignee] = [
                'total_todos' => $todos->count(),
                'total_pending_todos' => $todos->where('status', 'pending')->count(),
                'total_timetracked_completed_todos' => Todo::where('assignee', $assignee)->where('status', 'completed')->sum('time_tracked'),
            ];
        }

        return response()->json(['assignee_summary' => $result]);
    }

    return response()->json(['error' => 'Invalid type'], 400);
}

}

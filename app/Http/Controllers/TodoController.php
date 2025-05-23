<?php

namespace App\Http\Controllers;

use App\Exports\TodoExport;
use App\Models\Todo;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TodoController extends Controller
{
    public function index () {
        $tasks = Todo::all();
        return response()->json([
            'status' => 'success',
            'message' => 'Get all Data tugas',
            'data' => $tasks        
        ],200);
    }

    public function store(Request $request) {
      $validated =  $request->validate([
            'title' => 'required|string',
            'assignee' => 'nullable|string',
            'due_date' => 'required|date|after_or_equal:today',
            'time_tracked' => 'nullable|numeric',
            'status' => 'nullable|in:pending,open,in-progress,completed',
            'priority' => 'required|in:low,medium,high'
        ]);
        $validated['status'] = $validated['status'] ?? 'pending';
        $validated['time_tracked'] = $validated['time_tracked'] ?? 0;

        $todo = Todo::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Tugas berhasil dibuat',
            'data' => $todo
        ],201);

    }


    public function exportExcel() {
        return Excel::download(new TodoExport, 'todos.xlsx');
    }
 
}

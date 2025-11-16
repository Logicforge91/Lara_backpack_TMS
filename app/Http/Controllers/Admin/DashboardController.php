<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Employee;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // --- Tasks Completed per User ---
        $users = Employee::all();
        $completedTasksCount = [];
        foreach ($users as $user) {
            $completedTasksCount[$user->name] = Task::where('employee_id', $user->id)
                ->where('status', 'Completed')
                ->count();
        }

        // --- Pending vs Completed ---
        // $pendingCount = Task::where('status', 'Pending')->count();
        $pendingCount = Task::whereIn('status', ['Pending', 'In Progress'])->count();
        $completedCount = Task::where('status', 'Completed')->count();

        // --- Productivity Score ---
        $productivity = [];
        foreach ($users as $user) {
            $total = Task::where('employee_id', $user->id)->count();
            $completed = Task::where('employee_id', $user->id)
                ->where('status', 'Completed')->count();
            $score = $total > 0 ? round(($completed / $total) * 100, 2) : 0;
            $productivity[$user->name] = $score;
        }

        // --- Burn-down Chart ---
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $dates = [];
        $tasksLeft = [];
        for ($date = $startOfMonth; $date <= $endOfMonth; $date->addDay()) {
            $dates[] = $date->format('d M');
            $tasksLeft[] = Task::whereDate('created_at', '<=', $date)
                ->where('status', 'Pending')->count();
        }

        return view('admin.dashboard', compact(
            'completedTasksCount',
            'pendingCount',
            'completedCount',
            'productivity',
            'dates',
            'tasksLeft'
        ));
    }
}

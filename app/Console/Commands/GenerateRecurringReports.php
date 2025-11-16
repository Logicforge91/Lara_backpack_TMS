<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use App\Models\MonthlyReport;
use Carbon\Carbon;

class GenerateMonthlyReports extends Command
{
    protected $signature = 'tasks:generate-monthly-reports';
    protected $description = 'Generate monthly recurring tasks into the monthly_reports table';

    public function handle()
    {
        $today = Carbon::today();

        // Run only on 25th
        if ($today->day != 25) {
            $this->info("Today is not 25th. Skipping...");
            return;
        }

        $tasks = Task::where('is_recurring', true)
            ->where('recurring_type', 'monthly')
            ->whereDate('recurring_start_date', '<=', $today)
            ->where(function ($q) use ($today) {
                $q->whereDate('recurring_end_date', '>=', $today)
                  ->orWhereNull('recurring_end_date');
            })
            ->get();

        foreach ($tasks as $task) {
            MonthlyReport::create([
                'task_id'     => $task->id,
                'employee_id' => $task->employee_id,
                'task_name'   => $task->name,
                'description' => $task->description,
                'status'      => $task->status,
                'report_date' => $today->toDateString(),
            ]);
        }

        $this->info("Monthly Reports Generated Successfully for 25th!");
    }
}

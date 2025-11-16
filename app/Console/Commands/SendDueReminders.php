<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use App\Notifications\TaskDueReminderNotification;
use Carbon\Carbon;

class SendDueReminders extends Command
{
    protected $signature = 'tasks:due-reminders';
    protected $description = 'Send reminders for tasks due tomorrow';

    public function handle()
    {
        $tomorrow = Carbon::tomorrow()->toDateString();

        $tasks = Task::whereDate('due_date', $tomorrow)->get();

        foreach ($tasks as $task) {
            if ($task->employee) {
                $task->employee->notify(new TaskDueReminderNotification($task));
            }
        }

        $this->info("Due date reminders sent!");
    }
}

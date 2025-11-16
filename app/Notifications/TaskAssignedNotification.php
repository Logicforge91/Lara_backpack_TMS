<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use App\Models\Task;

class TaskAssignedNotification extends Notification
{
    use Queueable;

    public $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function via($notifiable)
    {
        return ['mail', 'slack'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Task Assigned')
            ->line('A new task has been assigned to you.')
            ->line('Task: ' . $this->task->name)
            ->line('Due Date: ' . $this->task->due_date)
            ->action('View Task', url('/admin/task/'.$this->task->id.'/show'));
    }

    public function toSlack($notifiable)
    {
        return (new SlackMessage)
            ->content("📌 *New Task Assigned*\n{$this->task->name}\nDue: {$this->task->due_date}");
    }
}

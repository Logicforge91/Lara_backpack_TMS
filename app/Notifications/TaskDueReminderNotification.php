<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use App\Models\Task;

class TaskDueReminderNotification extends Notification
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
            ->subject('Task Due Tomorrow')
            ->line("Reminder: Your task '{$this->task->name}' is due tomorrow.");
    }

    public function toSlack($notifiable)
    {
        return (new SlackMessage)
            ->content("⏳ *Task Due Tomorrow*\n{$this->task->name}");
    }
}

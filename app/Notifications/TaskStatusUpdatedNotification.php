<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use App\Models\Task;

class TaskStatusUpdatedNotification extends Notification
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
            ->subject('Task Status Updated')
            ->line("The status of your task '{$this->task->name}' was changed to: {$this->task->status}");
    }

    public function toSlack($notifiable)
    {
        return (new SlackMessage)
            ->content("🔄 *Task Status Updated*\n{$this->task->name}\nNew Status: {$this->task->status}");
    }
}

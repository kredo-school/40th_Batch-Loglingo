<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class AnsweredYourQuestion extends Notification
{
    use Queueable;

    public function __construct(
        public int $questionId,
        public string $questionTitle,
        public int $answerUserId,
        public string $answerUserName,
    ) {}

    /**
     * 通知の保存先
     */
    public function via(object $notifiable): array
    {
        return ['database','mail'];
    }

    /**
     * DBに保存されるデータ
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'question_answered',
            'question_id' => $this->questionId,
            'question_title' => $this->questionTitle,
            'answer_user_id' => $this->answerUserId,
            'answer_user_name' => $this->answerUserName,
            'url' => route('questions.show', $this->questionId),
        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New answer to your question')
            ->greeting('Hi ' . $notifiable->name)
            ->line($this->answerUserName . ' answered your question:')
            ->line($this->questionTitle)
            ->action(
                'View Question',
                route('questions.show', $this->questionId)
            )
            ->line('Keep learning with LogLingo!');
    }
}
<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class RepliedToDiscussion extends Notification
{
    public function __construct(
        public int $discussionId,
        public string $discussionTitle,
        public int $replyUserId,
        public string $replyUserName,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database','mail'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'discussion_replied',
            'discussion_id' => $this->discussionId,
            'discussion_title' => $this->discussionTitle,
            'reply_user_id' => $this->replyUserId,
            'reply_user_name' => $this->replyUserName,
            'url' => route('discussions.show', $this->discussionId),
        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New reply on your discussion')
            ->greeting('Hi ' . $notifiable->name)
            ->line($this->replyUserName . ' replied to your discussion:')
            ->line($this->discussionTitle)
            ->action('View Discussion', route('discussions.show', $this->discussionId))
            ->line('Keep teaching with LogLingo!');
    }
}

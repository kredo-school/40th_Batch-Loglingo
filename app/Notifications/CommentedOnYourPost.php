<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;


class CommentedOnYourPost extends Notification
{
    public function __construct(
        public int $postId,
        public string $postTitle,
        public int $commentUserId,
        public string $commentUserName,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database','mail'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'post_commented',
            'post_id' => $this->postId,
            'post_title' => $this->postTitle,
            'comment_user_id' => $this->commentUserId,
            'comment_user_name' => $this->commentUserName,
            'url' => route('posts.show', $this->postId),
        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New comment on your post')
            ->greeting('Hi ' . $notifiable->name)
            ->line($this->commentUserName . ' commented on your post:')
            ->line($this->postTitle)
            ->action('View Post', route('posts.show', $this->postId))
            ->line('Keep learning with LogLingo!');
    }
}
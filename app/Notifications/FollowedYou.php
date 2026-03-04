<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class FollowedYou extends Notification
{
    use Queueable;

    public function __construct(
        public int $followerId,
        public string $followerName,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail']; // mail 不要なら 'database' のみでもOK
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'followed_you',
            'follower_id' => $this->followerId,
            'follower_name' => $this->followerName,
            'url' => route('profile.show', $this->followerId),
        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('You have a new follower')
            ->greeting('Hi '.$notifiable->name)
            ->line($this->followerName.' started following you.')
            ->action(
                'View Profile',
                route('profile.show', $this->followerId)
            )
            ->line('Keep learning with LogLingo!');
    }
}
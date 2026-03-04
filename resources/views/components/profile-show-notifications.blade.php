@props(['notifications'])

<div class="space-y-4">
@forelse($notifications as $notification)

    @php
        $data = $notification->data;
    @endphp

    <a href="{{ route('notifications.read', $notification->id) }}"
       class="block p-4 rounded-lg border
       {{ is_null($notification->read_at) ? 'bg-blue-50' : 'bg-white' }}">

        <h4 class="text-lg font-bold text-gray-900 flex items-center gap-2">
            @if ($data['type'] === 'question_answered')
                <i class="fa-regular fa-circle-question text-blue-500"></i>
                <span>Your question got an answer</span>

            @elseif ($data['type'] === 'post_commented')
                <i class="fa-regular fa-comment text-green-500"></i>
                <span>New comment on your post</span>

            @elseif ($data['type'] === 'followed_you')
                <i class="fa-regular fa-user text-purple-500"></i>
                <span>New follower</span>
            @endif
        </h4>

        <p class="text-sm text-gray-600 mt-1 truncate whitespace-nowrap overflow-hidden">
            @if ($data['type'] === 'question_answered')
                {{ $data['answer_user_name'] }} answered: {{ $data['question_title'] }}
            @elseif ($data['type'] === 'post_commented')
                {{ $data['comment_user_name'] }} commented on: {{ $data['post_title'] }}
            @elseif ($data['type'] === 'followed_you')
                {{ $data['follower_name'] }} started following you
            @endif
        </p>

        <p class="text-xs text-gray-400 mt-2">
            {{ $notification->created_at->diffForHumans() }}
        </p>
    </a>

@empty
    <p class="text-gray-400 text-center py-10">
        No notifications yet.
    </p>
@endforelse
</div>
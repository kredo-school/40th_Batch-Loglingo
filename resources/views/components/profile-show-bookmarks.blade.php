@props(['bookmarks'])

<div class="space-y-4">
    @forelse($bookmarks as $bookmark)
        @php
            $item = $bookmark->bookmarkable; 
        @endphp

        @if($item instanceof \App\Models\Post)
            <x-post-card :post="$item" />
        @elseif($item instanceof \App\Models\Question)
            <x-question-card :question="$item" />
        @elseif($item instanceof \App\Models\Discussion)
            <x-discussion-card :discussion="$item" />
        @endif

    @empty
        <div class="bg-white rounded-2xl border border-gray-100 p-12 text-center">
            <p class="text-gray-500">No bookmarks yet.</p>
        </div>
    @endforelse

    <div class="mt-4">
        {{ $bookmarks->links() }}
    </div>
</div>
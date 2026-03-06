@props(['discussions'])

<div class="space-y-4">
    @forelse($discussions as $discussion)
        <x-discussion-card :discussion="$discussion" />
    @empty
        <div class="bg-white rounded-2xl border border-gray-100 p-12 text-center">
            <p class="text-gray-500">No discussions posted yet.</p>
        </div>
    @endforelse

    <div class="mt-8">
        {{ $discussions->links() }}
    </div>
</div>
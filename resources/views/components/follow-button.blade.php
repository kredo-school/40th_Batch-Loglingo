@props(['user', 'type' => 'default'])

@php
$isFollowing = auth()->user()->isFollowing($user);

// define the design
$baseClass = "font-bold transition-all duration-300 active:translate-y-1 disabled:opacity-50";

// choose class by type
$styles = [
'default' => [
'following' => 'bg-gray-200 text-gray-700 px-3 py-1 rounded-full',
'not_following' => 'bg-[#B178CC] text-white px-3 py-1 rounded-full'
],
'orange' => [ // for profile page
'following' => 'bg-[#fda211] border border-[#fda211] text-white px-6 py-1 rounded-xl hover:bg-[#fdb211]',
'not_following' => 'bg-white border-2 border-[#fda211] text-[#fda211] px-10 py-1 rounded-xl hover:border-[#fdbe11] hover:text-[#fdbe11]'
]
];

$currentStyle = $styles[$type] ?? $styles['default'];
@endphp

<div x-data="{ 
    following: {{ $isFollowing ? 'true' : 'false' }},
    loading: false,
    toggleFollow() {
    if (this.loading) return;
    this.loading = true;

    // 1. switch method 
    const url = this.following 
        ? '{{ route('follow.destroy', $user) }}' 
        : '{{ route('follow.store', $user) }}';
    
    const method = this.following ? 'DELETE' : 'POST';

    fetch(url, {
        method: method,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest' 
        }
    })
    .then(response => {
        if (!response.ok) throw new Error('Server error');
        return response.json();
    })
    .then(data => {
        this.following = !this.following;
        window.dispatchEvent(new CustomEvent('notify', { 
            detail: { message: data.message, type: 'success' } 
        }));
    })
    .catch(error => {
        console.error(error); 
        window.dispatchEvent(new CustomEvent('notify', { 
            detail: { message: 'Error occurred', type: 'error' } 
        }));
    })
    .finally(() => this.loading = false);
}
}">
  <button
    @click="toggleFollow()"
    :class="following ? '{{ $currentStyle['following'] }}' : '{{ $currentStyle['not_following'] }}'"
    class="{{ $baseClass }} min-w-[160px] inline-flex justify-center items-center"
    :disabled="loading">

    <span x-show="!loading" x-text="following ? '{{ $type === 'orange' ? 'Unfollow' : 'Following' }}' : 'Follow'"></span>
    <i x-show="loading" class="fa-solid fa-circle-notch animate-spin"></i>
  </button>
</div>
@props(['user'])

@php
$isFollowing = auth()->user()->isFollowing($user);
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
    :class="following ? 'bg-gray-200 text-gray-700' : 'bg-[#B178CC] text-white'"
    class="text-[13px] font-bold px-3 py-1 rounded-full hover:bg-[#a068ba] transition-all hover:scale-105 active:scale-95 disabled:opacity-50"
    :disabled="loading">
    <span x-show="!loading" x-text="following ? 'Following' : 'Follow'"></span>
    <i x-show="loading" class="fa-solid fa-circle-notch animate-spin"></i>
  </button>
</div>
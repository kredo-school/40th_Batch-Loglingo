@props(['model'])

<div x-data="{ 
    isBookmarked: {{ $model->isBookmarkedBy(auth()->user()) ? 'true' : 'false' }},
    loading: false,
    toggle() {
        if (this.loading) return;
        this.loading = true;
        
        fetch('{{ route('bookmarks.store') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                bookmarkable_id: {{ $model->id }},
                bookmarkable_type: @js(get_class($model))
            })
        })
        .then(res => {
            if (res.ok) {
                this.isBookmarked = !this.isBookmarked;

                // 修正：共通関数を呼び出す
                dispatchToast(
                    this.isBookmarked ? 'Saved to bookmarks!' : 'Removed from bookmarks', 
                    'success'
                );
            } else {
                dispatchToast('Something went wrong...', 'error');
            }
        })
        .catch(() => {
            dispatchToast('Connection error', 'error');
        })
        .finally(() => this.loading = false);
    }
}">
    <button @click="toggle" :class="loading ? 'opacity-50 cursor-not-allowed' : ''" class="transition-transform active:scale-125">
        <template x-if="isBookmarked">
            <i class="fa-solid fa-bookmark text-green-500"></i> {{-- already bookmarked --}}
        </template>
        <template x-if="!isBookmarked">
            <i class="fa-regular fa-bookmark text-gray-400 hover:text-green-400"></i> {{-- not yet --}}
        </template>
    </button>
</div>
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

                // トースト通知を飛ばす
                window.dispatchEvent(new CustomEvent('toast', { 
                    detail: { 
                        message: this.isBookmarked ? 'Saved to bookmarks!' : 'Removed from bookmarks',
                        type: 'success'
                    } 
                }));
            } else {
                // エラー時のトースト通知
                window.dispatchEvent(new CustomEvent('toast', { 
                    detail: { message: 'Something went wrong...', type: 'error' } 
                }));
            }
        })
        .catch(() => {
            window.dispatchEvent(new CustomEvent('toast', { 
                detail: { message: 'Connection error', type: 'error' } 
            }));
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
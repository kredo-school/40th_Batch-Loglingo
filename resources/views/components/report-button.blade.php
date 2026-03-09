@props(['model', 'reported' => false])

<div x-data="{ 
    reported: @js($reported),
    loading: false,
    sendReport() {
        if (this.reported || this.loading) return;
        
        if (!confirm('Are you sure you want to report this?')) return;

        this.loading = true;
        
        fetch('{{ route('report.store') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                reportable_id: {{ $model->id }},
                reportable_type: @js(get_class($model))
            })
        })
        .then(res => {
            if (res.ok) {
                this.reported = true;
                
                dispatchToast('Report submitted. Thank you.', 'success');
            } else {
                throw new Error();
            }
        })
        .catch(() => {
            dispatchToast('Failed to send report.', 'error');
        })
        .finally(() => this.loading = false);
    }
}">
    <button @click.stop="sendReport"
        :disabled="reported || loading"
        :class="{
                'text-red-500 opacity-100 cursor-default': reported,
                'text-gray-400 hover:text-red-500': !reported,
                'opacity-50': loading
            }"
        class="transition-all p-2 flex items-center gap-1 group">

        <i :class="reported ? 'fa-solid fa-flag' : 'fa-regular fa-flag'"
            class="group-active:scale-125 transition-transform"></i>

        <span x-show="reported" x-transition class="text-xs font-medium">Reported</span>
    </button>
</div>
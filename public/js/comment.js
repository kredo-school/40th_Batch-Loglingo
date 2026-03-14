document.addEventListener('alpine:init', () => {
    Alpine.data('commentForm', () => ({
        content: '',
        isSubmitting: false,
        
        resize(el) {
            el.style.height = 'auto';
            el.style.height = el.scrollHeight + 'px';
        },

        submit() {
            if (this.content.trim() === '') return;
            this.isSubmitting = true;
        }
    }));
});
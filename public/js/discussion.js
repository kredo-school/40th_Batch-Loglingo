document.addEventListener('alpine:init', () => {
    Alpine.data('discussionCard', () => ({
        openQuestion: false,
        isTruncated: false,

        toggleModal() {
            this.openQuestion = !this.openQuestion;
        },

        checkTruncation(el) {
            this.isTruncated = el.scrollHeight > el.clientHeight;
        }
        
    }));
});
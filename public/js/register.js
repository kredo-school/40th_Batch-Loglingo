document.addEventListener('alpine:init', () => {
    Alpine.data('termsManager', () => ({
        openTerms: false,
        readAll: false,

        // check scroll
        checkScroll(e) {
            const element = e.target;

            // check read all
            if (element.scrollHeight - element.scrollTop <= element.clientHeight + 10) {
                if (!this.readAll) {
                    this.readAll = true;
                    
                    // toast notification 
                    if (window.dispatchToast) {
                        dispatchToast('You can now agree to the terms.', 'success');
                    }
                }
            }
        }
    }));
});
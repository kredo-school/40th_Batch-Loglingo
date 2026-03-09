window.toastComponent = null;

document.addEventListener('alpine:init', () => {
    Alpine.data('toastNotification', () => ({
        show: false,
        message: '',
        type: 'success',

        init() {
            window.toastComponent = this;
            console.log('Toast system initialized!');
        },

        showToast(detail) {
            this.message = typeof detail === 'string' ? detail : detail.message;
            this.type = detail.type || 'success';
            this.show = true;
            setTimeout(() => { this.show = false }, 3000);
        }
    }));
});

window.dispatchToast = function (message, type = 'success') {
    if (window.toastComponent) {
        window.toastComponent.showToast({ message, type });
    } else {
        setTimeout(() => window.dispatchToast(message, type), 100);
    }
}
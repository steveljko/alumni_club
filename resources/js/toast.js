class Toast {
    constructor(toast) {
      this.toast = toast;
    }

    init() {
        document.addEventListener("DOMContentLoaded", () => {
            if (this.toast) this.hide();

            if (sessionStorage.getItem('toast')) {
                this.message(sessionStorage.getItem('toast'));
                sessionStorage.removeItem('toast');
            }
        });
    }

    message(message) {
        this.setMessage(message);
        this.show();
        this.hide();
    }

    setDelayedMessage(message) {
        sessionStorage.setItem('toast', message);
    }

    setMessage(message) {
        this.toast.innerHTML = message;
    }

    show() {
        if (toast) {
            this.toast.classList.remove('hidden');
            this.toast.classList.add('show');
        }
    }

    hide() {
        if (this.toast) {
            setTimeout(() => {
                this.toast.classList.remove('show');
                this.toast.classList.add('hidden');
                this.toast.innerHTML = '';
            }, 3500);
        }
    }
}

const toast = new Toast(document.getElementById('toast'));

toast.init();

export default toast;

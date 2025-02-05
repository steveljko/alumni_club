class Modal {
    constructor() {
        this.modal = document.getElementById('modal-container');
        this.dialog = document.getElementById('dialog');
        this.backdrop = document.getElementById('modal-backdrop');
        this.modal.addEventListener('keydown', (event) => {
            if (event.key == 'Escape') this.hide();
        });
    }

    toggleModal() {
        this.modal.classList.toggle('hidden');
        this.modal.setAttribute('aria-hidden', 'false');
        this.toggleBackdrop();
        this.modal.focus();
    }

    toggleBackdrop() {
        this.backdrop.classList.toggle('hidden');
    }

    clearDialog () {
        this.dialog.innerHTML = '';
        this.modal.setAttribute('aria-hidden', 'true');
        this.modal.blur();
    }

    setupCloseButtons() {
        if (this.modal) {
            this.modal.querySelectorAll('[data-hide-modal="true"]')
                    .forEach(e => e.addEventListener('click', _ => this.hide()));
        }
    }

    show() {
        this.toggleModal();
        this.setupCloseButtons();
    }

    hide() {
        this.toggleModal();
        this.clearDialog();
    }
}

export default new Modal;

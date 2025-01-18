import htmx from "htmx.org";
import toast from './toast';

window.htmx = htmx;

htmx.on("toast", (e) => toast.message(e.detail.value));
htmx.on("toast-after-redirect", (e) => toast.setDelayedMessage(e.detail.value));

function loadModalListeners(modal) {
    const modalBack =  modal.querySelector('#modal-back');
    const modalContent = modal.querySelector('#modal-content');

    if (modalContent) {
        modalContent.focus();
    }

    if (modal) {
        modal.addEventListener('keydown', (event) => {
            if (event.key == 'Escape') {
                const modal = document.getElementById('modal');
                modal.innerHTML = '';
                modal.classList.add('hidden');
            }
        });
    }
}

htmx.on('htmx:afterSwap', (e) => {
  if (e.detail.target.id == 'modal') {
        const modal = document.getElementById('modal');
        modal.classList.remove('hidden');

        loadModalListeners(modal);
  }
});

htmx.on('htmx:beforeSwap', (e) => {
    if (e.detail.target.id == 'modal' && !e.detail.xhr.response) {
        const modal = document.getElementById('modal');
        modal.classList.add('hidden');
        e.detail.shouldSwap = false;
    }
});

document.addEventListener('htmx:responseError', function (event) {
    const errors = JSON.parse(event.detail.xhr.response).errors;

    for (const [field, messages] of Object.entries(errors)) {
        const container = document.querySelector(`#${field}-validation-message`);
        container.classList.remove('hidden');
        container.innerHTML = messages[0];
    }
});


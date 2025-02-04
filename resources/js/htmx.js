import { setupPostboxTextarea, setupTextboxCharLimit } from './app.js';
import htmx from 'htmx.org';
import modal from './modal';
import toast from './toast';

window.htmx = htmx;

htmx.on("toast", (e) => toast.message(e.detail.value));
htmx.on("toast-after-redirect", (e) => toast.setDelayedMessage(e.detail.value));

htmx.onLoad(() => {
    setupPostboxTextarea();
    setupTextboxCharLimit();
});

htmx.on('htmx:afterSwap', (e) => {
  if (e.detail.target.id == 'dialog') {
        modal.show();
  }
});

htmx.on('htmx:beforeSwap', (e) => {
    if (e.detail.target.id == 'dialog' && !e.detail.xhr.response) {
        modal.hide();

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


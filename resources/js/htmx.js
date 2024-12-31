import htmx from "htmx.org";
import toast from './toast';

window.htmx = htmx;

htmx.on("toast", (e) => toast.message(e.detail.value));
htmx.on("toast-after-redirect", (e) => toast.setDelayedMessage(e.detail.value));

htmx.on("htmx:afterSwap", (e) => {
  if (e.detail.target.id == "modal") {
        const modal = document.getElementById("modal");
        modal.classList.toggle('hidden');
  }
});

htmx.on("htmx:beforeSwap", (e) => {
    if (e.detail.target.id == "modal" && !e.detail.xhr.response) {
        const modal = document.getElementById("modal");
        modal.classList.toggle('hidden');
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


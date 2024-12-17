import htmx from "htmx.org";

window.htmx = htmx;

document.addEventListener('htmx:responseError', function (event) {
    const errors = JSON.parse(event.detail.xhr.response).errors;

    for (const [field, messages] of Object.entries(errors)) {
        const container = document.querySelector(`#${field}-validation-message`);
        container.classList.remove('hidden');
        container.innerHTML = messages[0];
    }
});


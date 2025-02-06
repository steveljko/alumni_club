import { setupPostboxTextarea, setupTextboxCharLimit } from './app.js';
import htmx from 'htmx.org';
import modal from './modal';
import toast from './toast';
import { Cropt } from 'cropt';

window.htmx = htmx;

htmx.on("toast", (e) => toast.message(e.detail.value));
htmx.on("toast-after-redirect", (e) => toast.setDelayedMessage(e.detail.value));

htmx.onLoad((el) => {
    setupPostboxTextarea();
    setupTextboxCharLimit();

    // Avatar crop
    if (el.classList.contains('crop_avatar')) {
        const croptImage = document.getElementById('cropt_image');
        const cropt = new Cropt(croptImage, {
            "mouseWheelZoom": "on",
            "zoomerInputClass": "form-range"
        });
        const image = document.getElementById('image');
        if (image) cropt.bind(image.src);

        document.getElementById('crop').addEventListener('click', () => {
            cropt
                .toCanvas(256)
                .then((canvas) => {
                    canvas.toBlob((blob) => {
                        console.log(blob);
                        const file = new File([blob], `${Date.now()}.png`, { type: 'image/png' });
                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(file);

                        const avatarInput = document.querySelector('[name="avatar"]');
                        if (avatarInput) {
                            avatarInput.files = dataTransfer.files;
                            image.src = canvas.toDataURL();
                            croptImage.classList.toggle('hidden');
                            image.classList.toggle('hidden');
                            document.getElementById('crop').classList.toggle('hidden');
                        }
                    });
                });
        });
    }
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

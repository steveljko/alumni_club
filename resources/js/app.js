import './htmx';
import toast from './toast';
import { Cropt } from 'cropt';

function setupAccountDropdown() {
    const accountDropdownToggle = document.querySelector('#account button');
    const accountDropdown = document.getElementById('account_dropdown');
    const accountDropdownMobile = document.getElementById('account_dropdown_mobile');

    if (accountDropdownToggle) {
        accountDropdownToggle.addEventListener('click', () => {
            const isMobile = window.innerWidth <= 768;
            if (isMobile) {
                accountDropdownMobile.classList.toggle('hidden');
            } else {
                accountDropdown.classList.toggle('hidden');
            }
        });
    }
}

export function setupPostboxTextarea() {
    const textarea = document.getElementById('postboxTextarea');

    if (textarea) {
        textarea.addEventListener('input', (e) => {
            const target = e.target;
            target.style.height = 'auto';
            target.style.height = `${target.scrollHeight}px`;
        });
    }
}

export function setupTextboxCharLimit() {
    const textarea = document.querySelector('textarea');

    if (textarea) {
        const limit = parseInt(textarea.getAttribute('data-limit'), 10);
        const limitSpan = document.getElementById('current-letter-count');
        if (!limitSpan) { return; }
        const label = document.querySelector(`label[for=${textarea.getAttribute('name')}]`);
        const validationMessage = document.getElementById(`${textarea.getAttribute('name')}-validation-message`);

        function updateLetterCount() {
            const currLenght = textarea.value.length;
            limitSpan.textContent = currLenght;
            validationMessage.textContent = currLenght > limit
                ? `${label.innerHTML} limit exceeded by ${currLenght - limit} characters.`
                : '';
            validationMessage.classList.toggle('hidden', currLenght <= limit);
        };

        textarea.addEventListener('input', updateLetterCount);
        updateLetterCount();
    }
}

function setupAvatarCrop() {
    const croptImage = document.getElementById('cropt_image');

    if (croptImage) {
        let c = new Cropt(croptImage, {
            "mouseWheelZoom": "on",
            "zoomerInputClass": "form-range"
        });

        const buttons = {
            select: document.getElementById('selectBtn'),
            upload: document.getElementById('uploadBtn'),
            confirmCrop: document.getElementById('confirmCropBtn'),
            delete: document.getElementById('deleteBtn'),
            cancel: document.getElementById('cancelBtn'),
        }

        const avatarUploadInput = document.getElementById('avatarUploadInput');
        const profileAvatar = document.getElementById('profileAvatar');
        const modal = document.getElementById('resizeAvatarModal');

        buttons.select.addEventListener('click', () => avatarUploadInput.click());

        if (avatarUploadInput) {
            avatarUploadInput.addEventListener('change', (e) => {
                const image = avatarUploadInput.files[0];

                const imageSrc = URL.createObjectURL(image);
                c.bind(imageSrc);
                modal.classList.remove('hidden');
            });

            buttons.confirmCrop.addEventListener('click', (e) => {
                c.toCanvas(256).then((canvas) => {
                    canvas.toBlob((blob) => {
                        const file = new File([blob], `${Date.now()}.png`, { type: 'image/png' });
                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(file);

                        avatarUploadInput.files = dataTransfer.files;

                        let url = URL.createObjectURL(file);
                        profileAvatar.src = url;
                    });
                });

                modal.classList.toggle('hidden');
                buttons.upload.classList.remove('hidden');
                buttons.select.classList.add('hidden');
                buttons.delete.classList.add('hidden');
                buttons.cancel.classList.remove('hidden');
            });
        }
    }
}

document.addEventListener("DOMContentLoaded", () => {
    setupAccountDropdown();
    setupPostboxTextarea();
    setupTextboxCharLimit();
    setupAvatarCrop();
});

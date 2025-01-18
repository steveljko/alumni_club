import './htmx';
import toast from './toast';
import { Cropt } from 'cropt';

document.addEventListener("DOMContentLoaded", () => {
    const croptAvatar = document.getElementById('cropt_avatar');

    if (croptAvatar) {
        let c = new Cropt(croptAvatar, {
            "mouseWheelZoom": "on",
            "zoomerInputClass": "form-range"
        });

        const validationMessage = document.getElementById('avatar_url-validation-message');
        const uploadButton = document.getElementById('uploadButton');
        const avatarUpload = document.getElementById('avatar_upload');
        const cropImageUrl = document.getElementById('crop_image_url');
        const avatar = document.getElementById('avatar');
        const upload = document.getElementById('upload');
        const modal = document.getElementById('changeAvatarModal');
        const crop = document.getElementById('crop');

        uploadButton.addEventListener('click', () => avatarUpload.click());

        if (avatarUpload) {
            avatarUpload.addEventListener('change', (e) => {
                const image = avatarUpload.files[0];

                if (!image) return;

                const validTypes = ["image/png", "image/jpeg"];
                if (!validTypes.includes(image.type)) {
                    validationMessage.classList.remove('hidden');
                    validationMessage.innerHTML = 'Only PNG and JPEG are allowed!';
                    return;
                }

                const imageSrc = URL.createObjectURL(image);
                c.bind(imageSrc);
                modal.classList.remove('hidden');
            });

            crop.addEventListener('click', (e) => {
                c.toCanvas(500).then((canvas) => {
                    let url = canvas.toDataURL();
                    avatar.src = url;
                    cropImageUrl.value = url;
                });

                modal.classList.toggle('hidden');
                uploadButton.classList.add('hidden');
                upload.classList.remove('hidden');
            });
        }
    }

    // Home navigation bar
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

    const pbTextarea = document.getElementById('postboxTextarea');

    if (pbTextarea) {
        pbTextarea.addEventListener('input', (e) => {
            const target = e.target;
            target.style.height = 'auto';
            target.style.height = `${target.scrollHeight}px`;
        });
    }

    const textarea = document.querySelector('textarea');

    if (textarea) {
        const limit = parseInt(textarea.getAttribute('data-limit'), 10);
        const limitSpan = document.getElementById('current-letter-count');
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
});

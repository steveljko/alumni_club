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

        const avatarUpload = document.getElementById('avatar_upload');

        if (avatarUpload) {
            avatarUpload.addEventListener('change', (e) => {
                const image = avatarUpload.files[0];

                if (image) {
                    const imageSrc = URL.createObjectURL(image);
                    c.bind(imageSrc);
                }

                document.getElementById('modal').classList.toggle('hidden');
            });

            document.getElementById('crop').addEventListener('click', (e) => {
                c.toCanvas(500).then((canvas) => {
                    let url = canvas.toDataURL();
                    document.getElementById('avatar').src = url;
                    document.getElementById('crop_image_url').value = url;
                });

                document.getElementById('modal').classList.toggle('hidden');
                document.getElementById('upload').classList.remove('hidden');
            });
        }
    }

    // Home navigation bar
    const accountDropdownToggle = document.querySelector('#account button');
    const accountDropdown = document.getElementById('account_dropdown');
    const accountDropdownMobile = document.getElementById('account_dropdown_mobile');

    accountDropdownToggle.addEventListener('click', () => {
        const isMobile = window.innerWidth <= 768;

        if (isMobile) {
            accountDropdownMobile.classList.toggle('hidden');
        } else {
            accountDropdown.classList.toggle('hidden');
        }
    });

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

    const modal = document.getElementById('modal');
    const modalContent = document.getElementById('modal-content');

    if (modal) {
        document.addEventListener('click', (event) => {
            if (modal.classList.contains('hidden') === false && !modalContent.contains(event.target)) {
                modal.classList.toggle('hidden');
            }
        });

       modal.addEventListener('keydown', (event) => {
            if (event.key == 'Escape') {
                const modal = document.getElementById('modal');
                modal.classList.toggle('hidden');
            }
       });
    }
});

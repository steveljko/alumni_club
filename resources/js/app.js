import './htmx';
import toast from './toast';

document.addEventListener("DOMContentLoaded", () => {
    const textarea = document.querySelector("textarea");

    if (textarea) {
        const limit = parseInt(textarea.getAttribute('data-limit'), 10);
        const limitSpan = document.getElementById("current-letter-count");
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
                const modal = document.getElementById("modal");
                modal.classList.toggle('hidden');
            }
       });
    }
});

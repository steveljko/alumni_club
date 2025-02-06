import './htmx';
import toast from './toast';

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

document.addEventListener("DOMContentLoaded", () => {
    setupAccountDropdown();
    setupPostboxTextarea();
    setupTextboxCharLimit();
});

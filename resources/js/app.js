import './htmx';
import toast from './toast';
import { highlightAll } from '@speed-highlight/core';

function setupAccountDropdown() {
    const toggle = document.getElementById('user-profile-menu-toggle');
    const userProfileMenu = document.getElementById('user-profile-menu');
    const userProfileMenuContent = document.getElementById('user-profile-menu-content');

    toggle.addEventListener('click', () => {
        if (!userProfileMenu.classList.contains('hidden')) return;
        userProfileMenu.classList.toggle('hidden');
        userProfileMenuContent.focus();
    });

    userProfileMenuContent.addEventListener('focusout', (event) => {
        if (!userProfileMenuContent.contains(event.relatedTarget)) {
            userProfileMenu.classList.toggle('hidden');
        }
    });
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
    highlightAll();
});

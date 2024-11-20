import axios from 'axios';

document.addEventListener('DOMContentLoaded', function () {
    const links = document.querySelectorAll('#pagination a.control');

    links.forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            handleAction(this);
        });
    });

    renderPaginationLinks();
});

function handleAction(link) {
    const currentUrl = new URL(window.location.href);
    let page = parseInt(currentUrl.searchParams.get('page')) || 1;

    switch (link.getAttribute('data-action')) {
        case 'prev':
            page--;
            break;
        case 'next':
            page++;
            break;
        case 'first-page':
            page = 1;
            break;
        case 'last-page':
            page = parseInt(link.getAttribute('data-page'));
            break;
        case 'select':
            page = parseInt(link.getAttribute('data-page'));
            break;
        default:
            console.error(`"${action}" is not a valid action descriptor`);
            return;
    }

    currentUrl.searchParams.set('page', page);
    changeContent(currentUrl.toString());
    window.history.pushState({ page: page }, '', currentUrl.toString());
    renderPaginationLinks();
}

async function changeContent(url) {
    try {
        const response = await axios.get(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
        document.getElementById('users_table').innerHTML = response.data;
    } catch (error) {
        console.error('Error fetching page:', error);
    }
}

function renderPaginationLinks() {
    const pagination = document.querySelector('#pagination');
    const numbers = pagination.querySelector('.numbers');

    const currentUrl = new URL(window.location.href);
    const page = parseInt(currentUrl.searchParams.get('page')) || 1;

    const controls = {
      nextPageFull: document.querySelector('.control-next-page-full'),
      prevPageFull: document.querySelector('.control-prev-page-full'),
      nextPage: document.querySelector('.control-next-page'),
      prevPage: document.querySelector('.control-prev-page'),
    };

    const lastPage = parseInt(controls.nextPageFull.getAttribute('data-page')) || Infinity;

    controls.prevPage.style.display = (page === 1) ? 'none' : 'flex';
    controls.prevPageFull.style.display = (page === 1) ? 'none' : 'flex';
    controls.nextPage.style.display = (lastPage === page) ? 'none' : 'flex';
    controls.nextPageFull.style.display = (lastPage === page) ? 'none' : 'flex';

    const lowerBound = Math.max(1, page - 2);
    const upperBound = Math.min(lastPage, page + 2);

    numbers.innerHTML = '';

    for (let i = lowerBound; i <= upperBound; i++) {
        const link = document.createElement('a');
        link.className = `control-select ${i === page ? 'active' : ''}`;
        link.textContent = i;
        link.setAttribute('data-page', i);
        link.setAttribute('data-action', 'select');
        link.addEventListener('click', function (e) { e.preventDefault(); handleAction(this); });
        numbers.appendChild(link);
    }
}


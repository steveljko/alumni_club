import './bootstrap';

function showToast(message) {
    const snackbar = document.getElementById("toast");
    snackbar.innerHTML = message;
    snackbar.classList.remove("hidden");
    snackbar.classList.add("show");

    setTimeout(() => {
        snackbar.classList.remove("show");
        snackbar.classList.add("hidden");
    }, 3500);
}

if (sessionStorage.getItem('toast')) {
    showToast(sessionStorage.getItem('toast'));
    sessionStorage.removeItem('toast');
}

htmx.on("toast", (e) => showToast(e.detail.value));

htmx.on("toast-after-redirect", (e) => {
    sessionStorage.setItem('toast', e.detail.value);
});

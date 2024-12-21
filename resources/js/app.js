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


htmx.on("toast", (e) => showToast(e.detail.value));

function init() {
    const node = document.createElement('section');
    node.classList.add('gui-toast-group');

    document.firstElementChild.insertBefore(node, document.body);
    return node;
}

function createToast() {
    const node = document.createElement('output');

    node.innerText = text;
    node.classList.add('gui-toast');
    node.setAttribute('role', 'status');

    return node;
}

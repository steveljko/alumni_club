import axios from 'axios';

export default class Form {
    constructor(name) {
      this.name = name;
      this.form = document.querySelector(`form#${name}Form`);

      if (!this.form) {
        console.error(`Form with id ${name} not found.`);
        return null;
      }

      this.form.addEventListener('submit', (e) => {
        e.preventDefault();

        const loadingSpinner = this.form.querySelector('button svg');
        loadingSpinner.classList.remove('hidden');

        this.sendRequest();
      });

      this.onSuccessCallback = null;
    }

    setField(name, value) {
        const field = this.form.querySelector(`*[name="${name}"]`);
        field.value = value;
    }

    getField(name) {
        const field = this.form.querySelector(`*[name="${name}]"`);
        return field.value;
    }

    populate(data) {
        for (const key in data) this.setField(key, data[key]);
    }

    setOnSuccess(callback) {
        this.onSuccessCallback = callback;
    }

    async sendRequest() {
      const method = this.form.getAttribute('data-method') || "post";
      const url = this.form.getAttribute('data-action');
      const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

      let config = {
        method,
        url,
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          'X-CSRF-Token': csrfToken,
        }
      };

      if (method.toLowerCase() == "get") {
        const data = Object.fromEntries(new FormData(this.form));

        const params = new URLSearchParams(data);
        const newUrl = `${window.location.pathname}?${params.toString()}`;
        window.history.pushState({ path: newUrl }, '', newUrl);

        config.params = data;
      } else if(method.toLowerCase() == "post") {
        const hasQueryParams = window.location.search.length > 0;

        if (hasQueryParams) {
          const params = new URLSearchParams(window.location.search);
          config.url += '?' + params.toString();
        }

        config.data = new FormData(this.form);
      }

      try {
        const response = await axios(config);

        if (this.onSuccessCallback && typeof this.onSuccessCallback === 'function') {
          this.onSuccessCallback(response.data);
        }

        if (this.hasModal()) this.toggleModal()

        this.form.querySelector('svg').classList.add('hidden');
      } catch (err) {
        this.form.querySelector('svg').classList.add('hidden');
        const errors = err.response.data.errors;
        for (const [field, msg] of Object.entries(errors)) {
          this.setError(field, msg);
        }
      }
    }

    updateTableRecord(tableId, rowIdx) {
        const table = document.querySelector(`table#${tableId}`);
        const row = table.querySelector(`tr[data-index="${rowIdx}"]`);
        console.log(row);
    }

    setError(field, msg) {
        const errorField = document.querySelector(`#error-${field}`);
        errorField.innerHTML = msg;

        const el = document.querySelector(`form#${this.name}Form *[name="${field}"]`);

        switch (el.tagName.toLowerCase()) {
            case "input":
                el.addEventListener('keydown', e => errorField.innerHTML = '')
                break;
            case "select":
                el.addEventListener('change', e => errorField.innerHTML = '')
                break;
        }
    }

    // UI related
    hasModal() {
        const modal = document.querySelector(`div#${this.name}Modal`);
        return modal !== null;
    }

    toggleModal() {
        const modal = document.querySelector(`div#${this.name}Modal`);
        modal.classList.toggle('hidden');
    }
}

// initilize forms
window.Form = {
    instances: {},

    init(name) {
        const names = Array.isArray(name) ? name : [name];
        names.forEach(formName => this.instances[formName] = new Form(formName));
    },

    get(name) {
        return this.instances[name];
    }
};

document.addEventListener("DOMContentLoaded", function () {
    const forms = document.querySelectorAll('form');
    const formNames = Array.from(forms).map(form => form.getAttribute('id').replace(/Form$/, ''));
    window.Form.init(formNames);
});


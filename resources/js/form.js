import axios from 'axios';

export default class Form {
    constructor() {
      this.form = null;
      this.name = '';
    }

    getByName(name) {
      this.name = name;
      this.form = document.querySelector(`form#${name}Form`);

      this.form.addEventListener('submit', (e) => {
        e.preventDefault();
        this.sendRequest();
      });

      return this;
    }

    setField(name, value) {
        const field = document.querySelector(`form#${this.name}Form *[name="${name}"]`);
        field.value = value;
    }

    getField(name) {
        const field = document.querySelector(`form#${this.name}Form *[name="${name}"]`);
        return field.value;
    }

    populate(data) {
        for (const key in data) this.setField(key, data[key]);
    }

    async sendRequest() {
      const method = this.form.getAttribute('data-method') || "POST";
      const url = this.form.getAttribute('data-action');
      const data = new FormData(this.form);
      const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

      try {
        const resp = await axios({
          method,
          url,
          data,
          headers: {
            'X-Request-With': 'XMLHttpRequest',
            'X-CSRF-Token': csrfToken,
          }
        })

        this.toggleFormModal()
      } catch (err) {
        const errors = err.response.data.errors;
        for (const [field, msg] of Object.entries(errors)) {
          this.setError(field, msg);
        }
      }
    }

    setError(field, msg) {
        const errorField = document.querySelector(`#error-${field}`);
        errorField.innerHTML = msg;
        document
          .querySelector(`form#${this.name}Form *[name="${field}"]`)
          .addEventListener('keydown', e => errorField.innerHTML = '');

    }

    toggleFormModal() {
        const modal = document.querySelector(`div#${this.name}Modal`);
        modal.classList.toggle('hidden');
    }
}

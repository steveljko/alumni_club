export default class Form {
    constructor() {
      this.name = '';
    }

    getByName(name) {
      this.name = name;
      return this;
    }

    setField(fieldName, value) {
        const field = document.querySelector(`form#${this.name}Form *[name="${fieldName}"]`);
        field.value = value;
    }

    toggleFormModal() {
        const modal = document.querySelector(`div#${this.name}Modal`);
        modal.classList.toggle('hidden');
    }
}

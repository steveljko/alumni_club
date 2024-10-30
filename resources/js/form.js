export default class Form {
    constructor() {
      this.name = '';
    }

    getByName(name) {
      this.name = name;
      return this;
    }

    setField(fieldName, value) {
        const field = document.querySelector(`form#${this.name}Form input[name="${fieldName}"]`);
        field.value = value;
    }
}

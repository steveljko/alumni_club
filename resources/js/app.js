import Form from './form';

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

window.Form.init([
    'updateUser',
    'searchForm'
]);

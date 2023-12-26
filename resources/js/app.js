import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

window.Vue = require('vue');


Vue.component('user-create', require('./components/UserForm.vue').default);

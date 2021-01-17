import './bootstrap'
import Vue from 'vue'
import Vuelidate from 'vuelidate'

import LoginForm from './components/auth/LoginForm.vue'

Vue.use(Vuelidate)

Vue.component('login-form', LoginForm);

const renderVue = () => [].forEach.call(document.querySelectorAll('.vue-init:not(.vue-loaded)'), el => {
  el.classList.add('vue-loaded');

  new Vue({ el });
});

renderVue();

import Vue from 'vue'
import VueRouter from 'vue-router'
import store from './Store'
import App from './App.vue'
import './plugins/axios';
import VueTheMask from 'vue-the-mask'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'


Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

import LightBootstrap from './light-bootstrap-main'

import routes from './routes/routes'

import './registerServiceWorker'

import moment from 'moment';

import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

Vue.use(VueSweetalert2);
Vue.use(VueRouter)
Vue.use(LightBootstrap)
Vue.use(VueTheMask)

Vue.filter('toCurrency', function (value) {
  if (typeof value !== "number") {
    return value;
  }
  var formatter = new Intl.NumberFormat('pt-BR', {
    style: 'currency',
    currency: 'BRL'
  });
  return formatter.format(value);
});

const router = new VueRouter({
  routes,
  linkActiveClass: 'nav-item active',
  scrollBehavior: (to) => {
    if (to.hash) {
      return { selector: to.hash }
    } else {
      return { x: 0, y: 0 }
    }
  }
})

Vue.filter('toCurrency', function (value) {
  if (typeof value !== "number") {
    return value;
  }
  var formatter = new Intl.NumberFormat('pt-BR', {
    style: 'currency',
    currency: 'BRL'
  });
  return formatter.format(value);
});

Vue.filter('formatDate', function (value) {
  if (value) {
    return moment(String(value)).format('DD/MM/YYYY')
  }
})

new Vue({
  el: '#app',
  store,
  render: h => h(App),
  router
})

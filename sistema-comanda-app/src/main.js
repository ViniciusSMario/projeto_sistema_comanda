import Vue from "vue";
import App from "./App";
import router from "./router/index";
import store from "./store/index";
import PaperDashboard from "./plugins/paperDashboard";
import "vue-notifyjs/themes/default.css";
import VueSweetalert2 from 'vue-sweetalert2';
import moment from 'moment'

// If you don't need the styles, do not connect
import 'sweetalert2/dist/sweetalert2.min.css';
import VueTheMask from 'vue-the-mask'

Vue.config.productionTip = false

Vue.use(VueTheMask)
Vue.use(VueSweetalert2);
Vue.use(PaperDashboard);

router.beforeEach((to, from, next) => {
    const comandas_id = localStorage.getItem('comandas_id');

    if (to.path != '/login') {
        if (!comandas_id) {
            next('/login')
            return;
        } else {
            next();
        }
    } else {
        next();
    }
});


Vue.filter('toCurrency', function(value) {
    if (typeof value !== "number") {
        return value;
    }
    var formatter = new Intl.NumberFormat('pt-BR', {
        style: 'currency',
        currency: 'BRL'
    });
    return formatter.format(value);
});

Vue.filter('formatDate', function(value) {
    if (value) {
        return moment(String(value)).format('DD/MM/YYYY')
    }
})

new Vue({
    router,
    store,
    render: h => h(App)
}).$mount("#app");
import DashboardLayout from "@/layout/dashboard/DashboardLayout.vue";
// GeneralViews
import NotFound from "@/pages/NotFoundPage.vue";

// Admin pages
import Dashboard from "@/pages/Dashboard.vue";
import Icons from "@/pages/Icons.vue";
import Product from "@/pages/Produtos.vue";
import Cart from "@/pages/Cart.vue";
import Comanda from "@/pages/Comanda.vue";


const routes = [{
        path: "/",
        component: DashboardLayout,
        redirect: "/products",
        children: [{
                path: "products",
                name: "Produtos",
                component: Product
            },
            {
                path: "cart",
                name: "Carrinho",
                component: Cart
            },
            {
                path: "comand",
                name: "Comanda",
                component: Comanda
            },
        ]
    },
    { path: "*", component: NotFound },
    {
        path: "/login",
        name: "Dashboard",
        component: Dashboard,
    }
];

/**
 * Asynchronously load view (Webpack Lazy loading compatible)
 * The specified component must be inside the Views folder
 * @param  {string} name  the filename (basename) of the view to load.
function view(name) {
   var res= require('../components/Dashboard/Views/' + name + '.vue');
   return res;
};**/

export default routes;
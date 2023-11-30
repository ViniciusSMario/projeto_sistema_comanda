import DashboardLayout from '../layout/DashboardLayout.vue'
// GeneralViews
import NotFound from '../pages/NotFoundPage.vue'

// Admin pages
import Overview from 'src/pages/Overview.vue'
import UserProfile from 'src/pages/UserProfile.vue'
import Category from 'src/pages/Category/Category.vue'
import NewCategory from 'src/pages/Category/NewCategory.vue'
import EditCategory from 'src/pages/Category/EditCategory.vue'
import Product from 'src/pages/Product/Product.vue'
import NewProduct from 'src/pages/Product/NewProduct.vue'
import EditProduct from 'src/pages/Product/EditProduct.vue'
import Payment from 'src/pages/Payment/Payment.vue'
import NewPayment from 'src/pages/Payment/NewPayment.vue'
import EditPayment from 'src/pages/Payment/EditPayment.vue'

import Command from 'src/pages/Command/Command.vue'
import CommandAll from 'src/pages/Command/CommandAll.vue'
import CommandNewLaunch from 'src/pages/Command/CommandNewLaunch.vue'
import CommandOverview from 'src/pages/Command/CommandOverview.vue'
import CommandNew from 'src/pages/Command/CommandNew.vue'

import Kitchen from 'src/pages/Kitchen/Kitchen.vue'

import Table from 'src/pages/Table/Table.vue'
import NewTable from 'src/pages/Table/NewTable.vue'
import EditTable from 'src/pages/Table/EditTable.vue'


const routes = [{
        path: '/',
        component: DashboardLayout,
        redirect: '/admin/overview'
    },
    {
        path: '/admin',
        component: DashboardLayout,
        redirect: '/admin/overview',
        children: [{
                path: 'overview',
                name: 'Overview',
                component: Overview
            },
            {
                path: 'user',
                name: 'User',
                component: UserProfile
            },
            {
                path: 'category',
                name: 'Categorias',
                component: Category,
            },
            {
                path: 'category/newCategory',
                name: 'NewCategory',
                component: NewCategory,
            },
            {
                path: 'category/edit/:id',
                name: 'EditCategory',
                component: EditCategory,
            },
            {
                path: 'product',
                name: 'Produtos',
                component: Product
            },
            {
                path: 'product/newProduct',
                name: 'NewProduct',
                component: NewProduct,
            },
            {
                path: 'product/edit/:id',
                name: 'EditProduct',
                component: EditProduct,
            },
            {
                path: 'payment',
                name: 'Tipos de Pagamento',
                component: Payment
            },
            {
                path: 'payment/newPayment',
                name: 'NewPayment',
                component: NewPayment,
            },
            {
                path: 'payment/edit/:id',
                name: 'EditPayment',
                component: EditPayment,
            },
            {
                path: 'command/new',
                name: 'ComandaNew',
                component: CommandNew
            },
            {
                path: 'command',
                name: 'Comanda',
                component: Command
            },
            {
                path: 'commands/all',
                name: 'Todas as Comandas',
                component: CommandAll
            },
            {
                path: 'command/launch/:id',
                name: 'Comanda',
                component: CommandNewLaunch
            },
            {
                path: 'command/launch/:id/done',
                name: 'Comanda',
                component: CommandOverview
            },
            {
                path: 'kitchen',
                name: 'Kitchen',
                component: Kitchen
            },
            {
                path: 'table',
                name: 'Table',
                component: Table
            },
            {
                path: 'table/new',
                name: 'Table',
                component: NewTable
            },
            {
                path: 'table/edit/:id',
                name: 'Table',
                component: EditTable
            },
        ]
    },
    { path: '*', component: NotFound }
]

/**
 * Asynchronously load view (Webpack Lazy loading compatible)
 * The specified component must be inside the Views folder
 * @param  {string} name  the filename (basename) of the view to load.
function view(name) {
   var res= require('../components/Dashboard/Views/' + name + '.vue');
   return res;
};**/

export default routes
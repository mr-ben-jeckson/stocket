import { createRouter, createWebHistory } from "vue-router";
import MasterLayout from "../components/MasterLayout.vue";
import Dashboard from "../views/Dashboard.vue";
import Login from "../views/Login.vue";
import RequestPassword from "../views/RequestPassword.vue";
import ResetPassword from '../views/ResetPassword.vue';
import Products from "../views/Products.vue";
import store from "../store";

const routes = [
    {
        path: '/app',
        name: 'app',
        component: MasterLayout,
        meta: {
            isAuthCheck: true
        },
        children: [
            {
                path: 'dashboard',
                name: 'app.dashboard',
                component: Dashboard
            },
            {
                path: 'users',
                name: 'app.users',
                component: Dashboard
            },
            {
                path: 'products',
                name: 'app.products',
                component: Products
            },
            {
                path: 'inventories',
                name: 'app.inventories',
                component: Dashboard
            },
            {
                path: 'reports',
                name: 'app.reports',
                component: Dashboard
            }
        ]
    },
    {
        path: '/login',
        name: 'login',
        component: Login,
        meta: {
            isGuestCheck: true
        }
    },
    {
        path: '/request-password',
        name: 'requestPassword',
        component: RequestPassword,
        meta: {
            isGuestCheck: true
        }
    },
    {
        path: '/reset-password/:token',
        name: 'resetPassword',
        component: ResetPassword,
        meta: {
            isGuestCheck: true
        }
    }
]

const router = createRouter( {
    history: createWebHistory(),
    routes
})

router.beforeEach((to, from, next) => {
    if(to.meta.isAuthCheck && !store.state.user.token) {
        next({ name: 'login'});
    }
    else if (to.meta.isGuestCheck && store.state.user.token) {
        next({ name: 'app.dashboard'});
    } else {
        next();
    }
})

export default router;

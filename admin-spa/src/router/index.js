import { createRouter, createWebHistory } from "vue-router";
import MasterLayout from "../components/MasterLayout.vue";
import Dashboard from "../views/Dashboard.vue";
import Login from "../views/Login.vue";
import RequestPassword from "../views/RequestPassword.vue";
import ResetPassword from '../views/ResetPassword.vue';

const routes = [
    {
        path: '/app',
        name: 'app',
        component: MasterLayout,
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
                component: Dashboard
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
        component: Login
    },
    {
        path: '/request-password',
        name: 'requestPassword',
        component: RequestPassword
    },
    {
        path: '/reset-password/:token',
        name: 'resetPassword',
        component: ResetPassword
    }
]

const router = createRouter( {
    history: createWebHistory(),
    routes
})

export default router;

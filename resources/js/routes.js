import Home from './components/Home.vue';
import Login from './components/auth/Login.vue'
import Validar from './components/vistas_preguntas/Validar.vue'
import CustomersMain from './components/customers/Main.vue'
import CustomersList from './components/customers/List.vue'
import CustomersNew from './components/customers/New.vue'
import Customer from './components/customers/View.vue'
import Register from './components/auth/Register.vue'
export const routes = [
    {
        path: '/login',
        component: Login
    },
    {
        path: '/register',
        component: Register
    },
    {
        path: '/',
        component: Home,
        meta: {
            requireAuth: true
        }
    },
    {
        path: '/customers',
        component: CustomersMain,
        meta: {
            requireAuth: true
        },
        children: [
            {
                path: '/',
                component: CustomersList
            },
            {
                path: 'new',
                component: CustomersNew
            },
            {
                path: ':id',
                component: Customer
            }
        ]
    },
    {
        path: '/validar',
        component: Validar,
        meta: {
            requireAuth: true
        }
    },

];
import Home from './components/Home.vue';
import Login from './components/auth/Login.vue'
import Validar from './components/vistas_preguntas/Validar.vue'
import CustomersMain from './components/customers/Main.vue'
import CustomersList from './components/customers/List.vue'
import CustomersNew from './components/customers/New.vue'
import Customer from './components/customers/View.vue'
import Register from './components/auth/Register.vue'
import CrearPregunta from './components/vistas_preguntas/NewQuestion.vue'
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
        component: Home
    },
    {
        path: '/customers',
        component: CustomersMain,
        meta: {
            requiresAuth: true
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
            requiresAuth: true
        }
    },
    {
        path: '/preguntas',
        component: CrearPregunta,
        meta: {
            requiresAuth: true
        }
    },

];
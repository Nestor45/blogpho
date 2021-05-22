import Home from './components/Home.vue';
import Validar from './components/vistas_preguntas/Validar.vue'
export const routes = [
    {
        path: '/',
        component: Home
    },
    {
        path: '/validar',
        component: Validar
    }
];
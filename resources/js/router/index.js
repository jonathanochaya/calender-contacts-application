import { createRouter, createWebHistory } from 'vue-router';
import ExampleComponent from '../components/ExampleComponent.vue';
import ContactsCreate from '../views/ContactsCreate.vue';

const routes = [
    {
        path: '/',
        component: ExampleComponent
    },
    {
        path: '/contacts/create',
        component: ContactsCreate,
        name: 'createContact'
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});


export default router;

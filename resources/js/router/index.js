import { createRouter, createWebHistory } from 'vue-router';
import ExampleComponent from '../components/ExampleComponent.vue';
import ContactsCreate from '../views/ContactsCreate.vue';
import ContactsShow from '../views/ContactsShow.vue';

const routes = [
    {
        path: '/',
        component: ExampleComponent
    },
    {
        path: '/contacts/create',
        component: ContactsCreate,
        name: 'createContact'
    },
    {
        path: '/contacts/:id',
        component: ContactsShow,
        name: 'ContactsShow'
    },
    {
        path: '/contacts/:id/edit',
        Component: null,
        name: 'ContactsEdit'
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});


export default router;

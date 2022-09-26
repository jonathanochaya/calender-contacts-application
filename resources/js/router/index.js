import { createRouter, createWebHistory } from 'vue-router';
import ExampleComponent from '../components/ExampleComponent.vue';
import ContactsCreate from '../views/ContactsCreate.vue';
import ContactsShow from '../views/ContactsShow.vue';
import ContactsEdit from '../views/ContactsEdit.vue';
import ContactsIndex from '../views/ContactsIndex.vue';
import BirthdaysIndex from '../views/BirthdaysIndex.vue';

const routes = [
    {
        path: '/',
        component: ExampleComponent
    },
    {
        path: '/contacts',
        component: ContactsIndex,
        name: 'ContactsList'
    },
    {
        path: '/contacts/create',
        component: ContactsCreate,
        name: 'ContactCreate'
    },
    {
        path: '/contacts/:id',
        component: ContactsShow,
        name: 'ContactShow'
    },
    {
        path: '/contacts/:id/edit/',
        component: ContactsEdit,
        name: 'ContactEdit'
    },
    {
        path: '/birthdays',
        component: BirthdaysIndex,
        name: 'Birthdays'
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});


export default router;

import { createRouter, createWebHistory } from 'vue-router';
import ContactsCreate from '../views/ContactsCreate.vue';
import ContactsShow from '../views/ContactsShow.vue';
import ContactsEdit from '../views/ContactsEdit.vue';
import ContactsIndex from '../views/ContactsIndex.vue';
import BirthdaysIndex from '../views/BirthdaysIndex.vue';

const routes = [
    {
        path: '/',
        component: ContactsIndex,
        name: 'ContactsList',
        meta: { title: 'Contacts' }
    },
    {
        path: '/contacts/create',
        component: ContactsCreate,
        name: 'ContactCreate',
        meta: { title: 'Add New Contact' }
    },
    {
        path: '/contacts/:id',
        component: ContactsShow,
        name: 'ContactShow',
        meta: { title: 'Contact Details' }
    },
    {
        path: '/contacts/:id/edit/',
        component: ContactsEdit,
        name: 'ContactEdit',
        meta: { title: 'Edit Contact' }
    },
    {
        path: '/birthdays',
        component: BirthdaysIndex,
        name: 'Birthdays',
        meta: { title: "This Month's Birthdays" }
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});


export default router;

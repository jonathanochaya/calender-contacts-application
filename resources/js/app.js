/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import '../sass/app.scss';
import { createApp } from 'vue';

import router from './router/index';
import App from './components/App.vue';

const app = createApp({});

app.component('App', App);
app.use(router).mount('#app');

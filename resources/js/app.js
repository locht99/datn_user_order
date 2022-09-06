require('./bootstrap');
require("flowbite");

import { library } from '@fortawesome/fontawesome-svg-core';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { fas } from '@fortawesome/free-solid-svg-icons';
import { fab } from '@fortawesome/free-brands-svg-icons';
import { far } from '@fortawesome/free-regular-svg-icons';

import { createApp, h } from 'vue';
import { createRouter, createWebHistory } from 'vue-router'
import App from './App.vue'

import routes from './routes';

const router = createRouter({
    history: createWebHistory(),
    routes,
})
library.add(fas, fab, far);
const app = createApp(App)

app.component('font-awesome-icon', FontAwesomeIcon)
app.use(router)
app.mount('#app')

library.add(fas)

createApp(App)
    .use(router)
    .component('font-awesome-icon', FontAwesomeIcon)
    .mount('#app')
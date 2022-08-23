require('./bootstrap');
require("flowbite");

import { createApp } from 'vue';

import TestComponent from './components/TestComponent'

const app = createApp({})

app.component('test-view', TestComponent)

app.mount('#app')
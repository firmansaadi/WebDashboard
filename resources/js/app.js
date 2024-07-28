import './bootstrap';

import { createApp } from 'vue';
import App from "./App";
import router from './router';
import store from './store';
import 'jquery-slimscroll';
import 'bootstrap'
import './libs/theme'
import 'bootstrap-icons/font/bootstrap-icons.css';
import 'bs-stepper/dist/css/bs-stepper.min.css';

const app = createApp(App);
app.use(router)
app.use(store)
app.mount('#db-wrapper');

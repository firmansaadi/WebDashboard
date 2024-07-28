import axios from 'axios';
import jQuery from 'jquery';
import env from './config/env'
window.$ = window.jQuery = jQuery;
axios.defaults.baseURL = env.API_URL;
axios.defaults.withXSRFToken = true;
axios.defaults.withCredentials = true;

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

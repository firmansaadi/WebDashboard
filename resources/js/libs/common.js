import Cookies from 'js-cookie'
import env from '@/config/env'
export async function authFetch(url, options) {
    let token = Cookies.get('XSRF-TOKEN');
    if (!options) options = {};
    if (!options.headers) options.headers = {};
    var headers = Object.assign({
        'Content-Type': 'application/x-www-form-urlencoded',
        'X-XSRF-TOKEN': token
    }, options.headers);
    var params = Object.assign({
        method: 'GET'
    }, options);
    if (headers['Content-Type'] == null) delete headers['Content-Type'];
    params.headers = headers;
    return fetch(env.API_URL + url, params)
}

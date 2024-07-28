import { createStore } from "vuex";
import VuexPersistence from 'vuex-persist'

import { auth } from './modules/auth'

const vuexLocal = new VuexPersistence({
        storage: window.localStorage
    })
    // Create a new store instance.
export default createStore({
    modules: {
        auth,
    },
    plugins: [vuexLocal.plugin]
})

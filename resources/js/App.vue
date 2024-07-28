<template>
    <template v-if="theme === 'default'">
        <router-view></router-view>
    </template>

    <template v-if="theme === 'admin'">
        <AdminSidebar/>
        <div id="page-content">
        <AdminNavbar/>
        <div class="container-fluid px-6 py-4">
            <router-view></router-view>
        </div>
        </div>
        <AdminFooter/>
    </template>
</template>

<script>

import AdminNavbar from './layouts/AdminNavbar.vue'
import AdminSidebar from './layouts/AdminSidebar.vue'
import AdminFooter from './layouts/AdminFooter.vue'

export default {
name: "App",
components: {
    AdminNavbar,
    AdminSidebar,
    AdminFooter
},
data() {
    return {
        theme: "default",
        logged: false
    }
},
computed: {
},
mounted() {

},
beforeMount() {
},
watch: {
    $route(e) {
        if (e.meta.layout === 'default') {
            this.theme = "default";
        } else {
            this.theme = "admin";
        }
    }
},
}
</script>

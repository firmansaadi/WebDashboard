import { createRouter, createWebHashHistory, createWebHistory } from "vue-router";
import $ from 'jquery'
import Home from "@/views/Home";
import Dashboard from "@/views/Dashboard";
import Form from "@/views/examples/Form";
import Overview from "@/views/examples/Overview";
import Records from "@/views/examples/Records";
import NotFound from "@/views/NotFound";
import Exception from "@/views/Exception";
import exampleRoutes from "./example";
import store from "../store";
import env from "../config/env"

const baseRoutes = [{
        path: "/home",
        component: Home,
        name: "frontend.home",
        meta: {
            layout: 'default',
            auth: false,
        },
    },
    {
        path: "/",
        redirect: { name: "frontend.home" },
        name: "root"
    },
    {
        path: "/:pathMatch(.*)*",
        name: "route.notFound",
        component: NotFound,
        meta: {
            isFrontend: true,
        },
    },
    {
        path: "/exception",
        name: "route.exception",
        component: Exception,
    },
    {
        path: "/admin/dashboard",
        component: Dashboard,
        name: "admin.dashboard",
        meta: {
            layout: "admin",
            auth: true,
            permissionUrl: "dashboard",
            breadcrumb: "dashboard",
        },
    },
    {
        path: "/form",
        component: Form,
        name: "admin.form",
        meta: {
            layout: "admin",
            auth: true,
            permissionUrl: "form",
            breadcrumb: "form",
        },
    },
    {
        path: "/overview",
        component: Overview,
        name: "admin.chart",
        meta: {
            layout: "admin",
            auth: true,
            permissionUrl: "chart",
            breadcrumb: "chart",
        },
    },
    {
        path: "/records",
        component: Records,
        name: "admin.stepform",
        meta: {
            layout: "admin",
            auth: true,
            permissionUrl: "stepform",
            breadcrumb: "stepform",
        },
    },
    {
        path: "/profile",
        name: "auth.profile",
        component: () =>
            import ('@/views/Profile.vue'),
        meta: {
            layout: "admin",
            auth: true,
            sidebar: false,
            permissionUrl: "dashboard",
            breadcrumb: "dashboard",
        },
    },
    {
        path: '/login',
        name: 'auth.login',
        component: () =>
            import ('@/views/Login.vue'),
        meta: {
            layout: "default",
            auth: false
        },
    },
];

const routes = baseRoutes.concat(exampleRoutes)
const router = createRouter({
    linkActiveClass: "active",
    mode: 'history',
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    if (to.meta.auth === true) {
        console.log('auth', store.getters)
        if (!store.getters.authStatus) {
            next({ name: "auth.login" });
        } else {
            if (to.meta.layout === 'admin') {
                if (to.meta.sidebar === false) $("#db-wrapper").addClass("toggled");
                else $("#db-wrapper").removeClass("toggled");
                if (to.meta.access === false) {
                    next({
                        name: "route.exception",
                    });
                } else {
                    next();
                }
            } else {
                next();
            }
        }
    } else if (to.name === "auth.login" && store.getters.authStatus) {
        next({ name: "frontend.home" });
    } else {
        next();
    }
    //next();
});
export default router;

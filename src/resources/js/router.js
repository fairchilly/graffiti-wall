import Vue from "vue";
import VueRouter from "vue-router";

import HomePage from "./pages/HomePage";

Vue.use(VueRouter);

const router = new VueRouter({
    mode: "history",
    linkExactActiveClass: "active",
    routes: [
        {
            path: "/",
            name: "home",
            component: HomePage
        }
    ]
});

export default router;

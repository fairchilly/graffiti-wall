import Vue from "vue";
import VueRouter from "vue-router";

import HomePage from "./pages/HomePage";
import PostDetailPage from "./pages/PostDetailPage";

Vue.use(VueRouter);

const router = new VueRouter({
    mode: "history",
    linkExactActiveClass: "active",
    routes: [
        {
            path: "/",
            name: "home",
            component: HomePage
        },
        {
            path: "/post/:postId",
            name: "post-detail",
            component: PostDetailPage
        }
    ]
});

export default router;

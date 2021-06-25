import Vue from "vue";
import VueRouter from "vue-router";

import HomePage from "./pages/HomePage";
import CreatePostPage from "./pages/CreatePostPage";
import PostDetailPage from "./pages/PostDetailPage";
import TagSearchPage from "./pages/TagSearchPage";

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
            path: "/tag/:tag",
            name: "tag",
            component: TagSearchPage
        },
        {
            path: "/post/create",
            name: "create-post",
            component: CreatePostPage
        },
        {
            path: "/post/:postId",
            name: "post-detail",
            component: PostDetailPage
        }
    ]
});

export default router;

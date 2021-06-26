import Vue from "vue";
import VueRouter from "vue-router";

import HomePage from "./pages/HomePage";
import CreatePostPage from "./pages/CreatePostPage";
import PostDetailPage from "./pages/PostDetailPage";
import TagSearchPage from "./pages/TagSearchPage";
import ArchiveSearchPage from "./pages/ArchiveSearchPage";
import UserSearchPage from "./pages/UserSearchPage";
import EditPostPage from "./pages/EditPostPage";

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
            path: "/user/:username",
            name: "user",
            component: UserSearchPage
        },
        {
            path: "/tag/:tag",
            name: "tag",
            component: TagSearchPage
        },
        {
            path: "/archive/year/:year/month/:month",
            name: "archive",
            component: ArchiveSearchPage
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
        },
        {
            path: "/post/:postId/edit",
            name: "edit-post",
            component: EditPostPage
        }
    ]
});

export default router;

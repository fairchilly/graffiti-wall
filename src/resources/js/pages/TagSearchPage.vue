<template>
    <div>
        <nav
            class="breadcrumb is-medium has-bullet-separator"
            aria-label="breadcrumbs"
        >
            <ul>
                <li class="is-active">
                    <a href="/" aria-current="page">#{{ tag }}</a>
                </li>
            </ul>
        </nav>

        <spinner :loading="loading" />

        <span v-if="posts.length > 0">
            <div class="columns is-multiline ml-5">
                <div
                    class="column is-full mb-1"
                    v-for="post in posts"
                    :key="post.id"
                >
                    <post-entry
                        :postid="post.id"
                        :name="post.user_name"
                        :username="post.user_username"
                        :tags="post.tags"
                        :content="post.content"
                        :date="post.created_at"
                    ></post-entry>
                </div>
            </div>
            <div class="columns" v-if="links && links.next">
                <div class="column">
                    <paginator></paginator>
                </div>
            </div>
        </span>
    </div>
</template>

<script>
export default {
    data: function() {
        return {
            tag: this.$route.params.tag,
            posts: [],
            links: null,
            loading: true
        };
    },
    async mounted() {
        await this.loadPosts();
    },
    methods: {
        loadPosts: async function(url = null) {
            const urlPath = url
                ? url
                : `${process.env.MIX_BASE_URL}/api/tags/${this.tag}`;

            await axios
                .get(urlPath)
                .then(this.sleeper(1000))
                .then(response => {
                    this.posts = [...this.posts, ...response.data.data];
                    this.links = response.data.links;
                    this.loading = false;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        loadMore: async function() {
            if (this.links && this.links.next) {
                await this.loadPosts(this.links.next);
            }
        },
        updateTag: function() {
            this.tag = this.$route.params.tag;
        }
    },
    watch: {
        $route() {
            this.updateTag();
        },
        tag: function(val) {
            this.posts = [];
            this.loading = true;
            this.loadPosts();
        }
    }
};
</script>

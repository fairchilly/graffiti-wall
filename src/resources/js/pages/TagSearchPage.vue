<template>
    <div>
        <div
            class="is-flex is-justify-content-space-between is-align-items-flex-end mb-5 mr-5"
        >
            <back-to-graffiti-wall-button />
            <div class="tag is-dark is-large">#{{ tag }}</div>
        </div>

        <spinner :loading="loading" />

        <post-list :posts="posts" :links="links"></post-list>
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
                    alertify.notify(
                        `Unable to search for #${this.tag}`,
                        "error",
                        5
                    );
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

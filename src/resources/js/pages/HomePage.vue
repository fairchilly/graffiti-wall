<template>
    <div>
        <div
            class="is-flex is-justify-content-space-between is-align-items-flex-end mb-5 mr-5"
        >
            <div class="is-size-4 mb-2">Recent posts</div>
        </div>

        <spinner :loading="loading" />

        <post-list :posts="posts" :links="links"></post-list>
    </div>
</template>

<script>
export default {
    data: function() {
        return {
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
            const urlPath = url ? url : `${process.env.MIX_BASE_URL}/api/posts`;

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
                        "Unable to load most recent posts",
                        "error",
                        5
                    );
                });
        },
        loadMore: async function() {
            if (this.links && this.links.next) {
                await this.loadPosts(this.links.next);
            }
        }
    }
};
</script>

<template>
    <div>
        <span v-if="loading">
            <div class="spinner"></div>
        </span>
        <span v-if="posts.length > 0">
            <div class="columns is-multiline">
                <div
                    class="column is-one-third"
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
            <div class="columns">
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
        }
    }
};
</script>

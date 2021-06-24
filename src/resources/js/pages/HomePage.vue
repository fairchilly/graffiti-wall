<template>
    <div>
        <span v-if="loading">
            <div class="spinner"></div>
        </span>
        <div class="columns is-multiline" v-if="posts.length > 0">
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
                ></post-entry>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data: function() {
        return {
            posts: [],
            loading: true
        };
    },
    async mounted() {
        await this.loadPosts();
    },
    methods: {
        loadPosts: async function() {
            await axios
                .get(`${process.env.MIX_BASE_URL}/api/posts`)
                .then(response => {
                    this.posts = response.data.data;
                    this.loading = false;
                })
                .catch(error => {
                    console.log(error);
                });
        }
    }
};
</script>

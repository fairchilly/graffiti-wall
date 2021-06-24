<template>
    <span>
        <span v-if="loading">
            <div class="spinner"></div>
        </span>

        <span v-if="!loading">
            <article class="media" v-if="post">
                <div class="media-content">
                    <div class="content">
                        <p>
                            <strong>John Smith</strong>
                            <small>@johnsmith</small>
                            <small>31m</small>
                            <br />
                            <span v-html="post.content">
                                {{ post.content }}
                            </span>
                        </p>
                    </div>
                    <nav class="level is-mobile">
                        <div class="level-left">
                            <a class="level-item">
                                <span class="icon is-small"
                                    ><i class="fas fa-reply"></i
                                ></span>
                            </a>
                            <a class="level-item">
                                <span class="icon is-small"
                                    ><i class="fas fa-retweet"></i
                                ></span>
                            </a>
                            <a class="level-item">
                                <span class="icon is-small"
                                    ><i class="fas fa-heart"></i
                                ></span>
                            </a>
                        </div>
                    </nav>
                </div>
                <div class="media-right">
                    <button class="delete"></button>
                </div>
            </article>
        </span>
    </span>
</template>

<script>
export default {
    data: function() {
        return {
            post: [],
            loading: true
        };
    },
    async mounted() {
        await this.loadPost();
    },
    methods: {
        loadPost: async function() {
            const { postId } = this.$route.params;
            await axios
                .get(`${process.env.MIX_BASE_URL}/api/posts/${postId}`)
                .then(response => {
                    this.post = response.data.data;
                    this.loading = false;
                })
                .catch(error => {
                    console.log(error);
                });
        }
    }
};
</script>

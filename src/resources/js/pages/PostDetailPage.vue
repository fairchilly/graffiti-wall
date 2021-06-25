<template>
    <span>
        <spinner :loading="loading" />

        <span v-if="!loading">
            <article class="card has-background-white">
                <div class="card-content">
                    <div class="content">
                        <div class="columns">
                            <div
                                class="column is-flex is-justify-content-space-between"
                            >
                                <div>
                                    <strong>{{ post.user_name }}</strong>
                                    <small class="has-text-grey">
                                        @{{ post.user_username }}
                                    </small>
                                    <br />
                                </div>
                                <div>
                                    <small>
                                        {{
                                            post.created_at
                                                | moment("MMMM D, YYYY h:mm A")
                                        }}
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="columns">
                            <div class="column pt-0" v-html="post.content">
                                {{ post.content }}
                            </div>
                        </div>
                        <div class="columns">
                            <div class="column pt-0">
                                <p v-if="post.tags.length > 0">
                                    <a
                                        v-for="tag in post.tags"
                                        :key="post.id + tag.id"
                                    >
                                        <span class="tag is-dark mr-1">
                                            {{ tag.value }}
                                        </span>
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
            <div class="columns">
                <div class="column">
                    <router-link
                        :to="{ name: 'home' }"
                        class="button is-link is-light mt-5"
                    >
                        Back to the Graffiti Wall
                    </router-link>
                </div>
            </div>
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
                .then(this.sleeper(1000))
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

<template>
    <span>
        <spinner :loading="loading" />

        <span v-if="!loading">
            <div class="mb-5">
                <back-to-graffiti-wall-button />
            </div>

            <article
                class="card has-background-white ml-5 mr-3 is-shadowless is-radiusless post-no-hover"
            >
                <div class="card-content">
                    <div class="content">
                        <div class="columns">
                            <div
                                class="column is-flex is-justify-content-space-between"
                            >
                                <div>
                                    <strong>{{ post.user_name }}</strong>
                                    <small class="has-text-grey">
                                        <router-link
                                            :to="{
                                                name: 'user',
                                                params: {
                                                    username: post.user_username
                                                }
                                            }"
                                        >
                                            @{{ post.user_username }}
                                        </router-link>
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
                                <tags :id="post.id" :tags="post.tags" />
                            </div>
                        </div>
                    </div>
                </div>
                <header
                    v-if="canModify"
                    class="card-header is-shadowless post-header is-flex is-justify-content-center"
                >
                    <router-link
                        :to="{
                            name: 'edit-post',
                            params: {
                                postId: post.id
                            }
                        }"
                    >
                        <button class="button mt-2 mb-2">
                            <i class="fas fa-pencil-alt pr-1"></i> Edit
                        </button>
                    </router-link>
                    <button class="button ml-2 mt-2 mb-2" @click="deletePost()">
                        <i class="fas fa-trash-alt pr-1"></i> Delete
                    </button>
                </header>
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
                .then(this.sleeper(1000))
                .then(response => {
                    this.post = response.data.data;
                    this.loading = false;
                })
                .catch(error => {
                    alertify.notify("Unable to load post", "error", 5);
                });
        },
        deletePost: async function() {
            const headers = {
                Authorization: `Bearer ${$cookies.get("token")}`
            };

            const url = `${process.env.MIX_BASE_URL}/api/posts/${this.post.id}`;

            await axios
                .delete(url, {
                    headers
                })
                .then(response => {
                    this.$router.push({
                        name: "home"
                    });
                    alertify.notify("Post deleted", "success", 5);
                })
                .catch(error => {
                    console.log(error);
                    alertify.notify("Unable to delete post", "error", 5);
                });
        }
    },
    computed: {
        canModify: function() {
            let canModify = false;

            const isAuthenticated =
                $cookies.isKey("token") && $cookies.isKey("user");

            if (isAuthenticated) {
                canModify = $cookies.get("user").id === this.post.user_id;
            }

            return canModify;
        }
    }
};
</script>

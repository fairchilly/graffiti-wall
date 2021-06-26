<template>
    <div>
        <spinner :loading="loading" />

        <span v-if="!loading">
            <div class="mb-5">
                <back-to-graffiti-wall-button />
            </div>

            <span v-if="canModify">
                <div class="field">
                    <label class="label">Write on the Graffiti Wall:</label>
                    <div class="control">
                        <textarea
                            id="editor"
                            class="textarea"
                            placeholder="The #graffitwall is great!"
                            rows="10"
                            v-model="post.content"
                        ></textarea>
                    </div>
                </div>
                <div class="field is-grouped">
                    <div class="control">
                        <button
                            class="button is-info"
                            @click="editPost()"
                            :disabled="
                                post.content.length < 4 ||
                                    post.content.length > 65535
                            "
                        >
                            Update post
                        </button>
                    </div>
                    <div class="control">
                        <router-link
                            :to="{ name: 'home' }"
                            class="button is-link is-light"
                        >
                            Cancel
                        </router-link>
                    </div>
                </div>
            </span>
            <span v-if="!canModify">
                <article class="message is-danger">
                    <div class="message-body">
                        <p><strong>Error</strong></p>
                        You don't own this post!
                    </div>
                </article>
            </span>
        </span>
    </div>
</template>

<script>
import { required, minLength, maxLength } from "vuelidate/lib/validators";

export default {
    data: function() {
        return {
            post: { content: "" },
            canModify: false,
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
        editPost: async function() {
            let content = this.post.content.replace(/(?:\r\n|\r|\n)/g, "<br>");

            const headers = {
                Authorization: `Bearer ${$cookies.get("token")}`
            };

            const url = `${process.env.MIX_BASE_URL}/api/posts/${this.post.id}`;

            await axios
                .put(
                    url,
                    {
                        content
                    },
                    {
                        headers
                    }
                )
                .then(response => {
                    this.$router.push({
                        name: "post-detail",
                        params: { postId: this.post.id }
                    });
                    alertify.notify(
                        "Post updated to the Graffiti Wall",
                        "success",
                        5
                    );
                })
                .catch(error => {
                    console.log(error);
                    alertify.notify("Unable to edit post", "error", 5);
                });
        },

        checkCanModify: function() {
            const isAuthenticated =
                $cookies.isKey("token") && $cookies.isKey("user");

            if (this.post) {
                this.canModify = $cookies.get("user").id === this.post.user_id;
            }
        }
    },
    watch: {
        post: function(val) {
            this.checkCanModify();
        }
    },
    validations: {
        content: {
            required,
            minLength: minLength(3),
            maxLength: maxLength(65535)
        }
    }
};
</script>

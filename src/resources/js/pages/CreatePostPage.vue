<template>
    <div>
        <div class="field">
            <label class="label">Write on the Graffiti Wall:</label>
            <div class="control">
                <textarea
                    id="editor"
                    class="textarea"
                    placeholder="The #graffitwall is great!"
                    rows="10"
                    v-model="content"
                ></textarea>
            </div>
        </div>
        <div class="field is-grouped">
            <div class="control">
                <button
                    class="button is-info"
                    @click="post()"
                    :disabled="content.length < 4 || content.length > 65535"
                >
                    Post as @{{
                        isAuthenticated
                            ? $cookies.get("user").username
                            : "anonymous"
                    }}
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
    </div>
</template>

<script>
export default {
    data: function() {
        return {
            content: ""
        };
    },
    methods: {
        post: async function() {
            let content = this.content.replace(/(?:\r\n|\r|\n)/g, "<br>");

            // Change the call, based on if a user is logged in
            let headers;
            let url;
            if (this.isAuthenticated) {
                headers = {
                    Authorization: `Bearer ${$cookies.get("token")}`
                };
                url = `${process.env.MIX_BASE_URL}/api/posts/auth`;
            } else {
                headers = {};
                url = `${process.env.MIX_BASE_URL}/api/posts`;
            }

            await axios
                .post(
                    url,
                    {
                        content
                    },
                    {
                        headers
                    }
                )
                .then(response => {
                    const id = response.data.data.id;
                    this.$router.push({
                        name: "post-detail",
                        params: { postId: id }
                    });

                    alertify.notify(
                        "Post added to the Graffiti Wall",
                        "success",
                        5
                    );
                })
                .catch(error => {
                    alertify.notify("Unable to post", "error", 5);
                });
        }
    },
    computed: {
        isAuthenticated: function() {
            const isAuthenticated =
                $cookies.isKey("token") && $cookies.isKey("user");

            return isAuthenticated;
        }
    }
};
</script>

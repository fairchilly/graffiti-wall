<template>
    <div>
        <div class="field">
            <label class="label">Write on the Graffiti Wall:</label>
            <div class="control">
                <textarea
                    id="editor"
                    class="textarea is-radiusless"
                    placeholder="The #graffitwall is great!"
                    rows="10"
                    v-model="content"
                ></textarea>
            </div>
        </div>
        <div class="field is-grouped">
            <div class="control">
                <button class="button is-info" @click="post(false)">
                    Post as @shannon
                </button>
            </div>
            <div class="control">
                <button class="button is-dark" @click="post(true)">
                    Post as @anonymous
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
    mounted() {
        var quill = new Quill("#editor", {
            modules: {
                toolbar: [
                    [{ header: [1, 2, false] }],
                    ["bold", "italic", "underline"]
                ]
            },
            theme: "snow"
        });
    },
    methods: {
        post: async function(anonymous = true) {
            console.log(this.content);
            await axios
                .post(`${process.env.MIX_BASE_URL}/api/posts`, {
                    content: this.content
                })
                .then(response => {
                    console.log(response.data);
                })
                .catch(error => {
                    console.log(error);
                });
        }
    }
};
</script>

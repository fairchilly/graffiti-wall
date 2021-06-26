<template>
    <span v-if="posts.length > 0">
        <div class="columns is-multiline ml-5">
            <div
                class="column is-full pb-0 pt-0"
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
        <div class="columns" v-if="links && links.next">
            <div class="column">
                <paginator></paginator>
            </div>
        </div>
    </span>
</template>

<script>
export default {
    props: ["posts", "links"],
    methods: {
        loadMore: async function() {
            if (this.links && this.links.next) {
                await this.$parent.loadMore();
            }
        }
    }
};
</script>

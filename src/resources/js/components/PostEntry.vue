<template>
    <article class="media">
        <router-link :to="{ name: 'post-detail', params: { postId: postid } }">
            <figure class="media-left">
                <p class="image is-64x64">
                    <img
                        src="https://bulma.io/images/placeholders/128x128.png"
                    />
                </p>
            </figure>
            <div class="media-content">
                <div class="content">
                    <p>
                        <strong>{{ name }}</strong>
                        <small>@{{ username }}</small>
                        <br />
                        {{ content }}
                    </p>

                    <p v-if="tags.length > 0">
                        <a v-for="tag in tags" :key="postid + tag.id">
                            <span class="tag mr-1">
                                {{ tag.value }}
                            </span>
                        </a>
                    </p>
                </div>
            </div>
            <div class="media-right">
                <small>June 13, 2021</small>
            </div>
        </router-link>
    </article>
</template>

<script>
export default {
    props: ["postid", "name", "username", "tags", "content"]
};
</script>

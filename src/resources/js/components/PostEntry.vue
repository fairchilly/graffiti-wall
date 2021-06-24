<template>
    <article class="media">
        <figure class="media-left">
            <p class="image is-64x64">
                <img src="https://bulma.io/images/placeholders/128x128.png" />
            </p>
        </figure>
        <div class="media-content">
            <div class="content">
                <p>
                    <strong>{{ name }}</strong>
                    <small>@{{ username }}</small>
                    <br />
                    <span v-html="content">
                        {{ content }}
                    </span>
                </p>

                <p v-if="tags.length > 0">
                    <a v-for="tag in tags" :key="postid + tag.id">
                        <span
                            class="tag has-text-white-bis mr-1"
                            v-bind:style="{
                                backgroundColor: tag.hex_colour
                            }"
                        >
                            {{ tag.value }}
                        </span>
                    </a>
                </p>
            </div>
        </div>
        <div class="media-right">
            <small>June 13, 2021</small>
        </div>
    </article>
</template>

<script>
export default {
    props: ["postid", "name", "username", "tags", "content"]
};
</script>

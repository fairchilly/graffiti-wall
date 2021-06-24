<template>
    <article class="card has-background-white">
        <router-link
            :to="{ name: 'post-detail', params: { postId: postid } }"
            class="has-text-dark"
        >
            <div class="card-content">
                <div class="content">
                    <div class="columns">
                        <div
                            class="column is-flex is-justify-content-space-between"
                        >
                            <div>
                                <strong>{{ name }}</strong>
                                <small class="has-text-grey">
                                    @{{ username }}
                                </small>
                                <br />
                            </div>
                            <div>
                                <small>
                                    {{ date | moment("MMMM D, YYYY h:mm A") }}
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="columns">
                        <div class="column pt-0">
                            {{ content }}
                        </div>
                    </div>
                    <div class="columns">
                        <div class="column pt-0">
                            <p v-if="tags.length > 0">
                                <a v-for="tag in tags" :key="postid + tag.id">
                                    <span class="tag is-dark mr-1">
                                        {{ tag.value }}
                                    </span>
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </router-link>
    </article>
</template>

<script>
export default {
    props: ["postid", "name", "username", "tags", "content", "date"]
};
</script>

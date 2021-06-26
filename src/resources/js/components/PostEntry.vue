<template>
    <article class="card has-background-white is-shadowless is-radiusless post">
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
                                    <router-link
                                        :to="{
                                            name: 'user',
                                            params: {
                                                username: username
                                            }
                                        }"
                                    >
                                        @{{ username }}
                                    </router-link>
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
                            <tags :id="postid" :tags="tags" />
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

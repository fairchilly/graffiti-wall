<template>
    <div>
        <article class="message is-info">
            <div class="message-body is-size-4">
                Posts from {{ monthName }} {{ year }}
            </div>
        </article>

        <spinner :loading="loading" />

        <span v-if="posts.length > 0">
            <div class="columns is-multiline">
                <div
                    class="column is-one-third"
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
    </div>
</template>

<script>
export default {
    data: function() {
        return {
            year: this.$route.params.year,
            month: this.$route.params.month,
            months: [
                "January",
                "February",
                "March",
                "April",
                "May",
                "June",
                "July",
                "August",
                "September",
                "October",
                "November",
                "December"
            ],
            posts: [],
            links: null,
            loading: true
        };
    },
    async mounted() {
        await this.loadPosts();
    },
    methods: {
        loadPosts: async function(url = null) {
            const urlPath = url
                ? url
                : `${process.env.MIX_BASE_URL}/api/posts/year/${this.year}/month/${this.month}`;

            await axios
                .get(urlPath)
                .then(this.sleeper(1000))
                .then(response => {
                    this.posts = [...this.posts, ...response.data.data];
                    this.links = response.data.links;
                    this.loading = false;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        loadMore: async function() {
            if (this.links && this.links.next) {
                await this.loadPosts(this.links.next);
            }
        },
        updateYearAndMonth: function() {
            this.year = this.$route.params.year;
            this.month = this.$route.params.month;
        }
    },
    watch: {
        $route() {
            this.updateYearAndMonth();
        },
        date: function(val) {
            this.posts = [];
            this.loading = true;
            this.loadPosts();
        }
    },
    computed: {
        monthName: function() {
            return this.months[this.month - 1];
        },
        date: function() {
            return "" + this.year + this.month;
        }
    }
};
</script>

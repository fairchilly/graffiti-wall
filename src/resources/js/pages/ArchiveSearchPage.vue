<template>
    <div>
        <div
            class="is-flex is-justify-content-space-between is-align-items-flex-end mb-5 mr-5"
        >
            <back-to-graffiti-wall-button />
            <div class="is-size-5">{{ monthName }} {{ year }} Posts</div>
        </div>

        <spinner :loading="loading" />

        <post-list :posts="posts" :links="links"></post-list>
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
                    alertify.notify(
                        `Unable to load posts from summary ${this.monthName} ${this.year}`,
                        "error",
                        5
                    );
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

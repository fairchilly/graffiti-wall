<template>
    <aside class="menu">
        <p class="menu-label">
            Trending
        </p>
        <ul class="menu-list" v-if="trendingTags.length > 0">
            <li v-for="tag in trendingTags" :key="tag.id">
                <a>
                    <span
                        class="tag has-text-white-bis"
                    >
                        {{ tag.name }}
                    </span>
                </a>
            </li>
        </ul>
        <p class="menu-label">
            Archives
        </p>
        <ul class="menu-list" v-if="archives.length > 0">
            <li v-for="archive in archives" :key="archive.date">
                <a>
                    {{
                        archive.month +
                            " " +
                            archive.year +
                            " (" +
                            archive.count +
                            ")"
                    }}
                </a>
            </li>
        </ul>
    </aside>
</template>

<script>
export default {
    data: function() {
        return {
            trendingTags: [],
            archives: [],
            loading: true
        };
    },
    async mounted() {
        await this.loadTrendingTags();
        await this.loadArchives();
        this.loading = false;
    },
    methods: {
        loadTrendingTags: async function() {
            await axios
                .get(`${process.env.MIX_BASE_URL}/api/tags/trending`)
                .then(response => {
                    this.trendingTags = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        loadArchives: async function() {
            await axios
                .get(`${process.env.MIX_BASE_URL}/api/posts/archive-summary`)
                .then(response => {
                    this.archives = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        }
    }
};
</script>

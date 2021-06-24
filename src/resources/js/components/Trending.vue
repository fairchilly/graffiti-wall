<template>
    <span>
        <p class="menu-label">
            Trending
        </p>
        <span v-if="loading">
            <div class="spinner"></div>
        </span>
        <span v-if="!loading">
            <ul class="menu-list" v-if="trendingTags.length > 0">
                <li v-for="tag in trendingTags" :key="tag.id">
                    <a>
                        <span class="tag">
                            {{ tag.name }}
                        </span>
                    </a>
                </li>
            </ul>
        </span>
    </span>
</template>

<script>
export default {
    data: function() {
        return {
            trendingTags: [],
            loading: true
        };
    },
    async mounted() {
        await this.loadTrendingTags();
    },
    methods: {
        loadTrendingTags: async function() {
            await axios
                .get(`${process.env.MIX_BASE_URL}/api/tags/trending`)
                .then(response => {
                    this.trendingTags = response.data;
                    this.loading = false;
                })
                .catch(error => {
                    console.log(error);
                });
        }
    }
};
</script>

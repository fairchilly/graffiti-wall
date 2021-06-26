<template>
    <span>
        <p class="menu-label">
            Trending
        </p>
        <spinner :loading="loading" />
        <span v-if="!loading">
            <ul class="menu-list" v-if="trendingTags.length > 0">
                <li v-for="tag in trendingTags" :key="tag.id">
                    <router-link
                        :to="{
                            name: 'tag',
                            params: { tag: tag.name.substr(1) }
                        }"
                    >
                        <span class="tag is-dark">
                            {{ tag.name }}
                        </span>
                    </router-link>
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
                .then(this.sleeper(1000))
                .then(response => {
                    this.trendingTags = response.data;
                    this.loading = false;
                })
                .catch(error => {
                    alertify.notify("Unable to load trending tags", "error", 5);
                });
        }
    }
};
</script>

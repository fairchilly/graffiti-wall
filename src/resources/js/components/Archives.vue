<template>
    <span>
        <p class="menu-label">
            Archives
        </p>
        <spinner :loading="loading" />
        <span>
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
        </span>
    </span>
</template>

<script>
export default {
    data: function() {
        return {
            archives: [],
            loading: true
        };
    },
    async mounted() {
        await this.loadArchives();
    },
    methods: {
        loadArchives: async function() {
            await axios
                .get(`${process.env.MIX_BASE_URL}/api/posts/archive-summary`)
                .then(this.sleeper(1000))
                .then(response => {
                    this.archives = response.data;
                    this.loading = false;
                })
                .catch(error => {
                    console.log(error);
                });
        }
    }
};
</script>

<template>
    <span>
        <p class="menu-label">
            Archives
        </p>
        <spinner :loading="loading" />
        <span>
            <ul class="menu-list" v-if="archives.length > 0">
                <li v-for="archive in archives" :key="archive.date">
                    <router-link
                        :to="{
                            name: 'archive',
                            params: {
                                year: archive.year,
                                month: archive.month_number
                            }
                        }"
                    >
                        {{
                            archive.month +
                                " " +
                                archive.year +
                                " (" +
                                archive.count +
                                ")"
                        }}
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
                    alertify.notify(
                        "Unable to load archive summary",
                        "error",
                        5
                    );
                });
        }
    }
};
</script>

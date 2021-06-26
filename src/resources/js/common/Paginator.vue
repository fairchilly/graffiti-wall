<template>
    <nav
        class="pagination is-centered"
        role="navigation"
        aria-label="pagination"
    >
        <ul class="pagination-list">
            <li>
                <a
                    v-if="!loading"
                    class="button is-link is-light"
                    aria-label="Load More"
                    @click="clickLoadMore()"
                    >Load More</a
                >

                <span v-if="loading" class="button is-link is-light">
                    <spinner :loading="loading" size="small" />
                </span>
            </li>
        </ul>
    </nav>
</template>

<script>
export default {
    data: function() {
        return {
            loading: false
        };
    },
    methods: {
        clickLoadMore: async function() {
            this.loading = true;
            await this.$parent.loadMore();
            this.loading = false;
        }
    }
};
</script>

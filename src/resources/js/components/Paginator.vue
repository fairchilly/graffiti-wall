<template>
    <nav
        class="pagination is-centered"
        role="navigation"
        aria-label="pagination"
    >
        <ul class="pagination-list">
            <li>
                <a
                    class="button is-link is-light"
                    aria-label="Load More"
                    @click="clickLoadMore()"
                    >Load More</a
                >
            </li>
        </ul>
    </nav>
</template>

<script>
export default {
    methods: {
        clickLoadMore: function() {
            this.$parent.loadMore();
        }
    }
};
</script>

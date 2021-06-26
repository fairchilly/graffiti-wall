<template>
    <span v-if="loading">
        <div class="columns">
            <div class="column is-flex is-justify-content-center">
                <div
                    class="spinner"
                    v-bind:class="{ 'spinner-sm': size === 'small' }"
                ></div>
            </div>
        </div>
    </span>
</template>

<script>
export default {
    props: ["loading", "size"]
};
</script>

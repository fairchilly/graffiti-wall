<template>
    <span v-if="loading">
        <div class="columns">
            <div class="column is-flex is-justify-content-center">
                <div class="spinner"></div>
            </div>
        </div>
    </span>
</template>

<script>
export default {
    props: ["loading"]
};
</script>

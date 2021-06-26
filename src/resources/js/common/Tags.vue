<template>
    <span>
        <p v-if="tags.length > 0">
            <router-link
                :to="{
                    name: 'tag',
                    params: { tag: tag.value.substr(1) }
                }"
                v-for="tag in tags"
                :key="id + tag.id"
            >
                <span class="tag is-dark mr-1">
                    {{ tag.value }}
                </span>
            </router-link>
        </p>
    </span>
</template>

<script>
export default {
    props: ["id", "tags"]
};
</script>

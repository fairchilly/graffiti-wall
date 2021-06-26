<template>
    <span>
        <p
            class="help is-danger"
            v-if="field.hasOwnProperty('required') && !field.required"
        >
            {{ label }} is required
        </p>
        <p
            class="help is-danger"
            v-if="field.hasOwnProperty('minLength') && !field.minLength"
        >
            {{ label }} must have at least
            {{ field.$params.minLength.min }} letters.
        </p>
        <p
            class="help is-danger"
            v-if="field.hasOwnProperty('maxLength') && !field.maxLength"
        >
            {{ label }} must have at most
            {{ field.$params.maxLength.max }} letters.
        </p>
    </span>
</template>

<script>
export default {
    props: ["label", "field"],
    data: function() {
        return {
            username: null,
            password: null
        };
    }
};
</script>

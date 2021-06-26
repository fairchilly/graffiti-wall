<template>
    <span>
        <span v-if="field.$dirty">
            <p
                class="help is-danger"
                v-if="field.hasOwnProperty('required') && !field.required"
            >
                The {{ label }} is required
            </p>
            <p
                class="help is-danger"
                v-if="field.hasOwnProperty('minLength') && !field.minLength"
            >
                The {{ label }} must have at least
                {{ field.$params.minLength.min }} characters.
            </p>
            <p
                class="help is-danger"
                v-if="field.hasOwnProperty('maxLength') && !field.maxLength"
            >
                The {{ label }} must have at most
                {{ field.$params.maxLength.max }} characters.
            </p>
            <p
                class="help is-danger"
                v-if="field.hasOwnProperty('sameAs') && !field.sameAs"
            >
                The {{ label }} must be the same as the {{ matchLabel }}.
            </p>
        </span>
    </span>
</template>

<script>
export default {
    props: ["label", "matchLabel", "field"],
    data: function() {
        return {
            username: null,
            password: null
        };
    }
};
</script>

<template>
    <div class="modal" v-bind:class="{ 'is-active': active }">
        <div class="modal-background"></div>
        <div class="modal-card">
            <section
                class="modal-card-body is-flex is-flex-direction-column is-align-items-center graffiti-bg"
            >
                <div class="is-size-3">
                    Welcome to the
                </div>
                <div class="cursive is-size-1 mb-6">Graffiti Wall</div>
                <div class="is-size-4">
                    Post anonymously or not, the choice is yours!
                </div>
            </section>
            <footer class="modal-card-foot is-radiusless">
                <div class="container is-flex is-justify-content-center">
                    <button class="button is-success" @click="closeModal()">
                        Let's Go
                    </button>
                    <button class="button is-link" @click="signUp()">
                        Sign Up
                    </button>
                </div>
            </footer>
        </div>
    </div>
</template>

<script>
export default {
    props: ["active"],
    methods: {
        closeModal: function() {
            this.$parent.closeWelcomeModal();
        },
        signUp: function() {
            this.$parent.closeWelcomeModal();
            this.$parent.openCloseSignUpModal();
        }
    }
};
</script>

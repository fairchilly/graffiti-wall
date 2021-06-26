<template>
    <div class="pb-6 mb-6">
        <top-nav></top-nav>
        <welcome-modal :active="welcomeModalActive"></welcome-modal>
        <sign-up-modal :active="signUpModalActive"></sign-up-modal>
        <log-in-modal :active="logInModalActive"></log-in-modal>
        <div class="container is-fluid ml-6 mr-6">
            <div class="columns">
                <div class="column is-three-quarters">
                    <router-view></router-view>
                </div>
                <div class="column">
                    <side-nav></side-nav>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data: function() {
        return {
            welcomeModalActive: window.localStorage.getItem(
                "welcomeModalActive"
            )
                ? false
                : true,
            signUpModalActive: false,
            logInModalActive: false
        };
    },
    methods: {
        closeWelcomeModal: function() {
            window.localStorage.setItem("welcomeModalActive", false);
            this.welcomeModalActive = false;
        },
        openCloseSignUpModal: function() {
            this.signUpModalActive = !this.signUpModalActive;
        },
        openCloseLogInModal: function() {
            this.logInModalActive = !this.logInModalActive;
        }
    }
};
</script>

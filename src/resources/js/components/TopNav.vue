<template>
    <nav
        class="navbar is-dark mb-6"
        role="navigation"
        aria-label="main navigation"
    >
        <div class="navbar-brand">
            <router-link :to="{ name: 'home' }">
                <span id="logo" class="navbar-item">
                    Graffiti Wall
                </span>
            </router-link>

            <a
                role="button"
                class="navbar-burger"
                aria-label="menu"
                aria-expanded="false"
            >
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>

        <div id="navbarBasicExample" class="navbar-menu">
            <div class="navbar-end">
                <div class="navbar-item">
                    <div class="buttons">
                        <router-link
                            :to="{ name: 'create-post' }"
                            class="button is-info"
                        >
                            <strong>Post Now</strong>
                        </router-link>
                        <a class="button is-link" @click="openModal()">
                            <strong>Sign Up</strong>
                        </a>
                        <a class="button is-light">
                            Log In
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</template>

<script>
export default {
    methods: {
        openModal: function() {
            this.$parent.openCloseSignUpModal();
        }
    }
};
</script>

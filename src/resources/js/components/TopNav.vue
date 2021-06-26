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

        <div class="navbar-menu">
            <div class="navbar-end">
                <div class="navbar-item">
                    <div class="buttons">
                        <router-link
                            :to="{ name: 'create-post' }"
                            class="button is-info"
                        >
                            <strong>Post Now</strong>
                        </router-link>
                        <span v-if="!isAuthenticated">
                            <a
                                class="button is-link"
                                @click="openSignUpModal()"
                            >
                                <strong>Sign Up</strong>
                            </a>
                            <a
                                class="button is-light"
                                @click="openLogInModal()"
                            >
                                <strong>Log In</strong>
                            </a>
                        </span>
                        <span v-if="isAuthenticated">
                            <div
                                class="dropdown"
                                v-if="!loggingOut"
                                v-bind:class="{
                                    'is-active': showUserDropdown
                                }"
                                @mouseover="openCloseUserDropdown(true)"
                                @mouseleave="openCloseUserDropdown(false)"
                            >
                                <div class="dropdown-trigger">
                                    <button
                                        class="button"
                                        aria-haspopup="true"
                                        aria-controls="dropdown-menu"
                                    >
                                        <span>
                                            @{{ $cookies.get("user").username }}
                                        </span>
                                        <span class="icon is-small">
                                            <i class="fas fa-angle-down"></i>
                                        </span>
                                    </button>
                                </div>
                                <div
                                    class="dropdown-menu"
                                    id="dropdown-menu"
                                    role="menu"
                                >
                                    <div class="dropdown-content">
                                        <router-link
                                            :to="{
                                                name: 'user',
                                                params: {
                                                    username: $cookies.get(
                                                        'user'
                                                    ).username
                                                }
                                            }"
                                            class="dropdown-item"
                                        >
                                            My Posts
                                        </router-link>
                                        <hr class="dropdown-divider" />
                                        <a
                                            class="dropdown-item"
                                            @click="logOut()"
                                        >
                                            Log Out
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <a class="button is-light" v-if="loggingOut">
                                <spinner :loading="true" size="small" />
                            </a>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</template>

<script>
export default {
    data: function() {
        return {
            loggingOut: false,
            showUserDropdown: false
        };
    },
    methods: {
        openSignUpModal: function() {
            this.$parent.openCloseSignUpModal();
        },
        openLogInModal: function() {
            this.$parent.openCloseLogInModal();
        },
        openCloseUserDropdown: function(show) {
            this.showUserDropdown = show;
        },
        logOut: async function() {
            this.loggingOut = true;
            await axios
                .post(
                    `${process.env.MIX_BASE_URL}/api/authentication/logout`,
                    {},
                    {
                        headers: {
                            Authorization: `Bearer ${$cookies.get("token")}`
                        }
                    }
                )
                .then(this.sleeper(1000))
                .then(response => {
                    // do nothing
                })
                .catch(error => {
                    // Can't clear from server because may have already expired
                });

            // Unset token and user values
            $cookies.remove("token");
            $cookies.remove("user");

            // Refresh page
            this.$router.go(0);

            this.loggingOut = true;
        }
    },
    computed: {
        isAuthenticated: function() {
            const isAuthenticated =
                $cookies.isKey("token") && $cookies.isKey("user");

            return isAuthenticated;
        }
    }
};
</script>

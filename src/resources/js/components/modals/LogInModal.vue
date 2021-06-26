<template>
    <div class="modal" v-bind:class="{ 'is-active': active }">
        <div class="modal-background"></div>
        <div class="modal-card">
            <header
                class="modal-card-head cursive is-size-3 is-flex is-justify-content-center is-radiusless graffiti-bg"
            >
                Log In
            </header>
            <section class="modal-card-body">
                <div class="field">
                    <label class="label">Username</label>
                    <div class="control">
                        <input
                            class="input"
                            type="text"
                            required
                            pattern="[a-zA-Z0-9]+"
                            min="3"
                            max="30"
                        />
                    </div>
                </div>
                <div class="field">
                    <label class="label">Password</label>
                    <div class="control">
                        <input
                            class="input"
                            type="password"
                            required
                            min="5"
                            max="255"
                        />
                    </div>
                </div>
            </section>
            <footer
                class="modal-card-foot is-flex is-justify-content-center is-radiusless"
            >
                <button class="button is-link" @click="logIn()">Log In</button>
                <button class="button" @click="closeModal()">Cancel</button>
            </footer>
        </div>
    </div>
</template>

<script>
export default {
    props: ["active"],
    data: function() {
        return {
            username: false,
            password: false
        };
    },
    methods: {
        closeModal: function() {
            this.$parent.openCloseLogInModal();
        },
        logIn: async function() {
            await axios
                .post(`${process.env.MIX_BASE_URL}/api/authentication/login`, {
                    username: this.username,
                    password: this.password
                })
                .then(this.sleeper(1000))
                .then(response => {
                    console.log(response);
                    // this.posts = [...this.posts, ...response.data.data];
                    // this.links = response.data.links;
                    // this.loading = false;
                })
                .catch(error => {
                    console.log(error);
                });
        }
    }
};
</script>

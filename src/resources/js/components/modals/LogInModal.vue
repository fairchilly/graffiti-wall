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
                <form>
                    <div class="field">
                        <label class="label">Username</label>
                        <div class="control">
                            <input
                                class="input"
                                type="text"
                                v-model="$v.username.$model"
                                v-bind:class="{
                                    'is-danger':
                                        $v.username.$dirty &&
                                        $v.username.$invalid
                                }"
                            />
                        </div>
                        <validation-errors
                            :label="'username'"
                            :field="$v.username"
                        />
                    </div>
                    <div class="field">
                        <label class="label">Password</label>
                        <div class="control">
                            <input
                                class="input"
                                type="password"
                                v-model="$v.password.$model"
                                v-bind:class="{
                                    'is-danger':
                                        $v.password.$dirty &&
                                        $v.password.$invalid
                                }"
                            />
                        </div>
                        <validation-errors
                            :label="'password'"
                            :field="$v.password"
                        />
                    </div>
                </form>
            </section>
            <footer
                class="modal-card-foot is-flex is-justify-content-center is-radiusless"
            >
                <spinner :loading="loading" size="small" />

                <span v-if="!loading">
                    <button
                        class="button is-link"
                        :disabled="$v.$invalid"
                        @click="logIn()"
                    >
                        Log In
                    </button>
                    <button class="button" @click="closeModal()">Cancel</button>
                </span>
            </footer>
        </div>
    </div>
</template>

<script>
import { required, minLength, maxLength } from "vuelidate/lib/validators";
import ValidationErrors from "../../common/ValidationErrors.vue";

export default {
    components: { ValidationErrors },
    props: ["active"],
    data: function() {
        return {
            username: "",
            password: "",
            loading: false
        };
    },
    methods: {
        closeModal: function() {
            this.$parent.openCloseLogInModal();
        },
        logIn: async function() {
            this.loading = true;
            await axios
                .post(`${process.env.MIX_BASE_URL}/api/authentication/login`, {
                    username: this.username,
                    password: this.password
                })
                .then(this.sleeper(1000))
                .then(response => {
                    // Set token and user values
                    const { token, user } = response.data;
                    $cookies.set("token", token);
                    $cookies.set("user", user);

                    // Refresh page
                    this.$router.go(0);
                })
                .catch(error => {
                    alertify.notify("Invalid credentials", "error", 5);
                    this.loading = false;
                });
        }
    },
    validations: {
        username: {
            required,
            minLength: minLength(3),
            maxLength: maxLength(30)
        },
        password: {
            required,
            minLength: minLength(5),
            maxLength: maxLength(100)
        }
    }
};
</script>

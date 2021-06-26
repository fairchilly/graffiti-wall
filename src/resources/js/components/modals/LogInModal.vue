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
                                v-model="username"
                                v-bind:class="{
                                    'is-danger': $v.username.$invalid
                                }"
                            />
                        </div>
                        <validation-errors
                            :label="'Username'"
                            :field="$v.username"
                        />
                    </div>
                    <div class="field">
                        <label class="label">Password</label>
                        <div class="control">
                            <input
                                class="input"
                                type="password"
                                v-model="password"
                                v-bind:class="{
                                    'is-danger': $v.password.$invalid
                                }"
                            />
                        </div>
                        <validation-errors
                            :label="'Password'"
                            :field="$v.password"
                        />
                    </div>
                </form>
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
import { required, minLength, maxLength } from "vuelidate/lib/validators";
import ValidationErrors from "../ValidationErrors.vue";

export default {
    components: { ValidationErrors },
    props: ["active"],
    data: function() {
        return {
            username: null,
            password: null
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
                // .then(this.sleeper(1000))
                .then(response => {
                    console.log(response);
                    // this.posts = [...this.posts, ...response.data.data];
                    // this.links = response.data.links;
                    // this.loading = false;
                })
                .catch(error => {
                    alertify.notify("Invalid credentials", "error", 5);
                });
        }
    },
    validations: {
        username: {
            required,
            minLength: minLength(3),
            maxLength: maxLength(10)
        },
        password: {
            required,
            minLength: minLength(5),
            maxLength: maxLength(50)
        }
    }
};
</script>

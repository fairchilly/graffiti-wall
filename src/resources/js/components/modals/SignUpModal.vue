<template>
    <div class="modal" v-bind:class="{ 'is-active': active }">
        <div class="modal-background"></div>
        <div class="modal-card">
            <header
                class="modal-card-head cursive is-size-3 is-flex is-justify-content-center is-radiusless graffiti-bg"
            >
                Come Join The Fun
            </header>
            <section class="modal-card-body">
                <div class="field">
                    <label class="label">Name</label>
                    <div class="control">
                        <input
                            class="input"
                            type="text"
                            v-model="$v.name.$model"
                            v-bind:class="{
                                'is-danger': $v.name.$dirty && $v.name.$invalid
                            }"
                        />
                    </div>
                    <validation-errors :label="'name'" :field="$v.name" />
                </div>
                <div class="field">
                    <label class="label">Username</label>
                    <div class="control">
                        <input
                            class="input"
                            type="text"
                            v-model="$v.username.$model"
                            v-bind:class="{
                                'is-danger':
                                    $v.username.$dirty && $v.username.$invalid
                            }"
                        />
                        <validation-errors
                            :label="'username'"
                            :field="$v.username"
                        />
                    </div>
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
                                    $v.password.$dirty && $v.password.$invalid
                            }"
                        />
                        <validation-errors
                            :label="'password'"
                            :field="$v.password"
                        />
                    </div>
                </div>
                <div class="field">
                    <label class="label">Confirm Password</label>
                    <div class="control">
                        <input
                            class="input"
                            type="password"
                            v-model="$v.passwordConfirmation.$model"
                            v-bind:class="{
                                'is-danger':
                                    $v.passwordConfirmation.$dirty &&
                                    $v.passwordConfirmation.$invalid
                            }"
                        />
                        <validation-errors
                            :label="'password confirmation'"
                            :matchLabel="'password'"
                            :field="$v.passwordConfirmation"
                        />
                    </div>
                </div>
            </section>
            <footer
                class="modal-card-foot is-flex is-justify-content-center is-radiusless"
            >
                <spinner :loading="loading" />

                <span v-if="!loading">
                    <button
                        class="button is-link"
                        :disabled="$v.$invalid"
                        @click="signUp()"
                    >
                        Sign Up
                    </button>
                    <button class="button" @click="closeModal()">Cancel</button>
                </span>
            </footer>
        </div>
    </div>
</template>

<script>
import {
    required,
    minLength,
    maxLength,
    sameAs
} from "vuelidate/lib/validators";
import Spinner from "../Spinner.vue";
import ValidationErrors from "../ValidationErrors.vue";

export default {
    components: { Spinner },
    props: ["active"],
    data: function() {
        return {
            name: "",
            username: "",
            password: "",
            passwordConfirmation: "",
            loading: false
        };
    },
    methods: {
        closeModal: function() {
            this.$parent.openCloseSignUpModal();
        },
        signUp: async function() {
            this.loading = true;
            await axios
                .post(
                    `${process.env.MIX_BASE_URL}/api/authentication/register`,
                    {
                        name: this.name,
                        username: this.username,
                        password: this.password,
                        password_confirmation: this.passwordConfirmation
                    }
                )
                .then(this.sleeper(1000))
                .then(response => {
                    console.log(response);
                })
                .catch(error => {
                    alertify.notify(
                        "Unable to sign up, please try again",
                        "error",
                        5
                    );
                });
            this.loading = false;
        }
    },
    validations: {
        name: {
            required,
            minLength: minLength(3),
            maxLength: maxLength(100)
        },
        username: {
            required,
            minLength: minLength(3),
            maxLength: maxLength(30)
        },
        password: {
            required,
            minLength: minLength(5),
            maxLength: maxLength(100)
        },
        passwordConfirmation: {
            required,
            sameAs: sameAs(function() {
                return this.password;
            })
        }
    }
};
</script>

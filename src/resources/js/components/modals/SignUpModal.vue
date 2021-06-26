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
                            placeholder="Shannon Fairchild"
                            required
                            min="3"
                            max="50"
                        />
                    </div>
                </div>
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
                <div class="field">
                    <label class="label">Confirm Password</label>
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
                <button class="button is-link">Sign Up</button>
                <button class="button" @click="closeModal()">Cancel</button>
            </footer>
        </div>
    </div>
</template>

<script>
export default {
    props: ["active"],
    methods: {
        closeModal: function() {
            this.$parent.openCloseSignUpModal();
        }
    }
};
</script>

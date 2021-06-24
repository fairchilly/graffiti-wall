<template>
    <div class="modal" v-bind:class="{ 'is-active': modalActive }">
        <div class="modal-background"></div>
        <div class="modal-card">
            <section
                id="welcome"
                class="modal-card-body is-flex is-flex-direction-column is-align-items-center"
            >
                <div class="is-size-3">
                    Welcome to the
                </div>
                <div class="cursive is-size-1 mb-6">Graffiti Wall</div>
                <div class="is-size-4">
                    Post anonymously or not, the choice is yours
                </div>
            </section>
            <footer class="modal-card-foot is-radiusless">
                <div class="container">
                    <div class="columns is-centered">
                        <div class="column is-half">
                            <button
                                class="button is-success is-fullwidth"
                                @click="closeModal()"
                            >
                                Let's Go!
                            </button>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</template>

<script>
export default {
    data: function() {
        return {
            modalActive: window.localStorage.getItem("modalActive")
                ? false
                : true
        };
    },
    methods: {
        closeModal: function() {
            window.localStorage.setItem("modalActive", false);
            this.modalActive = false;
        }
    }
};
</script>

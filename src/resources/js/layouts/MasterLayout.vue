<template>
    <div>
        <top-nav></top-nav>
        <welcome-modal></welcome-modal>
        <div class="container is-fluid">
            <div class="columns">
                <div class="column is-three-quarters">
                    <router-view></router-view>
                </div>
                <div class="column ml-6">
                    <side-nav></side-nav>
                </div>
            </div>
        </div>
    </div>
</template>

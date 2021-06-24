<template>
    <nav
        class="navbar is-dark mb-6"
        role="navigation"
        aria-label="main navigation"
    >
        <div class="navbar-brand">
            <span id="logo" class="navbar-item">
                Graffiti Wall
            </span>

            <a
                role="button"
                class="navbar-burger"
                aria-label="menu"
                aria-expanded="false"
                data-target="navbarBasicExample"
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
                        <a class="button is-info">
                            <strong>Post Now</strong>
                        </a>
                        <a class="button is-primary">
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

<template>
    <div>
        <top-nav></top-nav>
        <welcome-modal></welcome-modal>
        <div class="container is-fluid">
            <div class="columns">
                <div class="column is-three-quarters">
                    <post-list></post-list>
                </div>
                <div class="column ml-6">
                    <side-nav></side-nav>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data: function() {
        return {
            hero: {
                msg: "Share your _",
                has_underscore: true,
                pause: false
            }
        };
    },
    mounted() {
        this.animateHeroMsg();
    },
    methods: {
        animateHeroMsg: function() {
            setInterval(() => {
                if (!this.hero.pause) {
                    this.hero.msg = this.hero.msg.substr(
                        0,
                        this.hero.msg.length - 1
                    );
                    if (this.hero.has_underscore) {
                        this.hero.msg += " ";
                        this.hero.has_underscore = false;
                    } else {
                        this.hero.msg += "_";
                        this.hero.has_underscore = true;
                    }
                }
            }, 470);

            this.typeAndEraseWord("thoughts", 3000);
            this.typeAndEraseWord("ideas", 9000);
            this.typeAndEraseWord("world", 15000, false);
        },
        typeAndEraseWord: function(word, time, erase = true) {
            setTimeout(() => {
                this.typeWord(word);
            }, time);

            if (erase) {
                time += 3000;
                setTimeout(() => {
                    this.eraseWord(word.length);
                }, time);
            }
        },

        typeWord: function(word) {
            this.hero.pause = true;
            word = word.split("");
            let index = 0;

            this.hero.msg = this.hero.msg.substr(0, this.hero.msg.length - 1);

            const timer = setInterval(() => {
                if (index < word.length) {
                    this.hero.msg += word[index];
                    index++;
                } else {
                    this.hero.msg += " ";
                    this.hero.pause = false;
                    clearInterval(timer);
                }
            }, 90);
        },
        eraseWord: function(length) {
            this.hero.pause = true;
            let stopIndex = this.hero.msg.length - length;

            const timer = setInterval(() => {
                if (this.hero.msg.length >= stopIndex) {
                    this.hero.msg = this.hero.msg.substr(
                        0,
                        this.hero.msg.length - 1
                    );
                } else {
                    this.hero.msg += " ";
                    this.hero.pause = false;
                    clearInterval(timer);
                }
            }, 90);
        }
    }
};
</script>

<template>
    <div>
        <p class="game-code">Game Code: {{ $root.game }}</p>
        <div class="app row no-gutters" style="height: 600px;">
            <app-board />

            <div class="player-list">
                <ul class="list-group">
                    <li v-for="user in $root.users" :key="user.name" class="list-group-item border-0">
                        {{ user.name }}
                        <span class="float-right">{{ user.score }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
import AppBoard from './AppBoard.vue';

export default {
    data() {
        return {
        }
    },

    components: {
        AppBoard,
    },

    created() {
        const self = this;

        Echo.channel('game.' + self.$root.game)
            .listen('UserScoreUpdated', (e) => {
                self.score = e.score;
            });
    },

    methods: {
        updateScore(user) {
            const self = this;

            const payload = {
                user: user.name,
                score: user.score += 10,
            }

            axios.post('/play', payload).then(response => {
                console.log(response);
            });
        }
    }

}
</script>

<style lang="scss" scoped>
.game-code {
    letter-spacing: 0.2px;
    word-spacing: 0;
    font-size: 0.8rem;
    margin: 0;
}
.app {
    box-shadow: $shadow-drama;
    .player-list {
        width: 300px;
        background-color: $primary;
        letter-spacing: 0;

        .list-group-item {
            background: transparent;
            border-radius: 0;
            transition: background-color 0.2s;

            &:hover {
                background: darken($primary, 10%);
            }
        }

        .badge {
            font-size: inherit;
        }
    }
}
</style>

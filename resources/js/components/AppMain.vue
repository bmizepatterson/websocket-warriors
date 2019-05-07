<template>
    <div class="app row no-gutters" style="height: 600px;">
        <div class="board">
        </div>

        <div class="player-list">
            <ul class="list-group">
                <li v-for="user in $root.users" :key="user.name" class="list-group-item border-0">
                    {{ user.name }}
                    <span class="add" @click="updateScore(user)">+</span>
                    <span class="float-right">{{ user.score }}</span>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
        }
    },

    created() {
        const self = this;

        Echo.channel('game')
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

            axios.post('/app', payload).then(response => {
                console.log(response);
            });
        }
    }

}
</script>

<style lang="scss" scoped>
.add {
    color: black;
    background-color:white;
    border-radius:50rem;
    cursor: pointer;
    vertical-align: middle;
    margin-left: 5px;
}
.app {
    box-shadow: $shadow-drama;

    .board {
        width: 600px;
        background-color: $gray-100;
        position: relative;
        box-shadow: 10px 0 5px -5px black;
    }
    
    .player-list {
        width: 300px;
        background-color: $primary;
        letter-spacing: 0;

        .list-group-item {
            background: transparent;
            border-radius: 0;
        }

        .badge {
            font-size: inherit;
        }
    }
}
</style>

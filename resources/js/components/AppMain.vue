<template>
    <div class="app row no-gutters" style="height: 600px;">
        <div class="board">
            <button id="test-button" class="btn btn-secondary" @click="updateScore">Click me</button>
        </div>

        <div class="player-list">
            <ul class="list-group">
                <li class="list-group-item">Player 1 <span class="badge badge-primary float-right">{{ score }}</span></li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            score: 0,
            users: [],
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
        updateScore() {
            const self = this;

            axios.post('/app', {score: self.score += 10}).then(response => {
                console.log(response);
            });
        }
    }

}
</script>

<style scoped>
.status-bar {
    font-size: 90%;
    position: absolute;
    bottom: 0;
    left: 5px;
}
</style>

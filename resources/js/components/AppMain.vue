<template>
    <div>
        <p class="game-code">Game Code: {{ $root.game.code }}</p>
        <div class="app row no-gutters" style="height: 600px;">
            <app-board />
            <app-player-list />
        </div>
    </div>
</template>

<script>
import AppBoard from './AppBoard.vue';
import AppPlayerList from './AppPlayerList.vue';

export default {
    components: {
        AppBoard,
        AppPlayerList,
    },

    mounted() {
        Echo.channel('game.' + this.$root.game.id)
            .listen('UserScoreUpdated', (e) => {
                console.log('Received score update:', e);
                this.$root.users.filter(u => u.name === e.user)[0].score = e.score;
            });
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
}
</style>

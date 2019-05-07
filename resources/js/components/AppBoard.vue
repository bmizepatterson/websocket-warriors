<template>
    <div class="board">
        <button class="btn btn-success" @click="click">Click me</button>
    </div>
</template>

<script>
export default {
    methods: {
        click() {
            axios.post('/api/play/' + this.$root.game.code, {
                user: this.$root.player.name,
                score: this.$root.player.score += 10,
            }).then(response => {
                console.log('Registered play:', response);
            }).catch(error => console.error(error));
        }
    }
}
</script>

<style lang="scss" scoped>
.board {
    width: 600px;
    background-color: $gray-100;
    position: relative;
    z-index: 1;
    box-shadow: 10px 0 5px -5px black;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}
</style>
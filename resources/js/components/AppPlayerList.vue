<template>
    <div class="player-list">
        <ul class="list-group">
            <li v-for="user in $root.users" :key="user.name" class="list-group-item border-0">
                {{ user.name }}
                <span class="float-right">{{ user.score }}</span>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    mounted() {
        Echo.channel('game.' + this.$root.game.id)
            .listen('UserJoined', (e) => {
                console.log('User ' + e.user.name + ' has joined the game');
                this.$root.users = e.game.users;
            })
            .listen('UserScoreUpdated', (e) => {
                console.log('Received score update:', e);
                this.$root.users.filter(u => u.id === e.user.id)[0].score = e.user.score;
            });
    }
}
</script>

<style lang="scss" scoped>
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
</style>
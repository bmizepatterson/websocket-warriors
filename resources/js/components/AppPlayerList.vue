<template>
    <div class="player-list">
        <transition-group name="list" tag="ul" class="list-group"> 
            <li v-for="user in $root.users" :key="user.id" class="list-group-item border-0">
                {{ user.name }}
                <span class="float-right">{{ user.score }}</span>
            </li>
        </transition-group>
    </div>
</template>

<script>
export default {
    mounted() {
        Echo.channel('game.' + this.$root.game.id)
            .listen('UserJoined', (e) => {
                console.log('User ' + e.user.name + ' has joined the game');
                this.$root.users.push(e.user);
            })
            .listen('UserLeft', (e) => {
                console.log('User ' + e.user.name + ' has left the game');
                const index = this.$root.users.findIndex(u => u.id === e.user.id);
                this.$root.users.splice(index, 1);
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
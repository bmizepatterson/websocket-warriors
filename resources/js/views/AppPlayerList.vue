<template>
    <div class="player-list d-flex flex-column">
        <transition-group name="list" tag="ul" class="list-group flex-grow-1"> 
            <li v-for="user in $root.users" :key="user.id" class="list-group-item border-0" style="word-spacing:initial;">
                <span>{{ user.name }}</span>
                <span class="float-right">{{ user.score }}</span>
            </li>
        </transition-group>
        <div class="flex-grow-0">
            <button class="btn btn-block btn-secondary btn-leave" @click="leave">Leave<font-awesome-icon icon="sign-out-alt" class="ml-2" /></button>
        </div>
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
    },
    methods: {
        leave() {
            axios.post('/api/play/' + this.$root.game.id + '/leave', this.$root.player);
            Echo.leave('game.' + this.$root.game.id);
            this.$router.push({ name: 'welcome' });
        }
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

    .btn-leave:active, .btn-leave:focus {
        position: relative;
        z-index: 1;
    }
}
</style>
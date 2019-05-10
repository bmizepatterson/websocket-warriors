<template>
    <div>
        <app-modal v-if="!$root.joined" @close="goHome">
            <template v-slot:header>
                <h3>{{ $route.params.gameCode }}</h3>
            </template>
            <template v-slot:body>
                <p>Enter your name so everyone in this chat room will know who you are.</p>
                <div class="input-group">
                    <label for="name" class="sr-only">Your Name</label>
                    <input id="name" class="form-control" placeholder="Your name" v-model="newUser" @keyup.enter="join" v-focus>
                    <div class="input-group-append">
                        <join-button @click="join" />
                    </div>
                </div>
            </template>
        </app-modal>
        <template v-else>
            <p class="game-code">{{ $route.params.gameCode }}</p>
            <div class="app row no-gutters flex-nowrap" style="height: 600px;">
                <app-board />
                <app-player-list />
            </div>
        </template>
    </div>
</template>

<script>
import AppBoard from './AppBoard.vue';
import AppPlayerList from './AppPlayerList.vue';
import AppModal from '../components/AppModal.vue';
import JoinButton from '../components/JoinButton.vue';

export default {

    components: {
        AppBoard,
        AppPlayerList,
        AppModal,
        JoinButton,
    },

    beforeRouteEnter(to, from, next) {
        // Redirect if this game doesn't exist
        axios.get('/api/play/' + to.params.gameCode)
            .then(() => next())
            .catch(error => {
                if (error.response.status === 404) {
                    next('/');
                }
            });
    },

    beforeRouteLeave(to, from, next) {
        if (this.$root.joined) {
            // Remove the user from the game
            console.log('Leaving game ' + this.$root.game.code);
            this.leave().then(next);
        } else {
            next();
        }
    },

    ready() {
        window.addEventListener('beforeunload', this.leave);
    },

    data() {
        return {
            newUser: '',
            loadingGame: false,
        }
    },

    methods: {
        join() {
            this.$root.$emit('loading-join', true);
            this.$root.player.name = this.newUser.toUpperCase();
            // Find the game in the DB
            axios.get('/api/play/' + this.$route.params.gameCode).then(response => {
                console.log('Joining existing game:', response.data);
                this.$root.join(response.data).then(() => this.$root.$emit('loading-join', true));
            });
        },
        goHome() {
            this.$router.push({ name: 'welcome' });
        },
        leave() {
            return axios.post('/api/play/' + this.$root.game.id + '/leave', { user: this.$root.player })
                .then(() => {
                    // Clear out game data
                    Echo.leave('game.' + this.$root.game.id);
                    this.$root.reset();
                })
        }
    }
}
</script>

<style lang="scss" scoped>
.game-code {
    letter-spacing: 0.2px;
    word-spacing: 0;
    margin: 0;
}
.app {
    box-shadow: $shadow-drama;
}
.input-group-append {
    transition: box-shadow 0.15s ease-in-out;
}
.form-control:active ~ .input-group-append,
.form-control:focus ~ .input-group-append {
    box-shadow: 0 0 0 3px $primary;
}
</style>

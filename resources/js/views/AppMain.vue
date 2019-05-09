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
            <p class="game-code">Game Code: {{ $route.params.gameCode }}</p>
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
}
.input-group-append {
    transition: box-shadow 0.15s ease-in-out;
}
.form-control:active ~ .input-group-append,
.form-control:focus ~ .input-group-append {
    box-shadow: 0 0 0 3px $primary;
}
</style>

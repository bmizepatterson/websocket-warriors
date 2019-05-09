<template>
    <div class="text-center">
        <h1 class="display-1 m-0 pb-5">WEBSOCKET WARRIORS</h1>
        <div class="row pt-5 justify-content-center">
            <div class="col-sm-6">
                <label for="name" class="sr-only">Your name</label>
                <input id="name" class="form-control" placeholder="Your name" v-model="newUser" @keyup.enter="start" autofocus>
            </div>
        </div>

        <div class="row no-gutters p-5">
            <div class="col-sm-3">
                <button class="btn btn-block btn-primary" @click="start">New Game
                    <font-awesome-icon v-if="loadingNewGame" icon="cog" class="loading-icon" pulse />
                </button>
            </div>
            <div class="col-sm-2 or">
                -&nbsp;OR&nbsp;-
            </div>
            <div class="col-sm-7">
                <div class="input-group">
                    <label for="game-code" class="sr-only">Game code</label>
                    <input id="game-code" class="form-control" placeholder="Game code" v-model="code" @keyup.enter="findGame">
                    <div class="input-group-append">
                        <join-button @click="findGame" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import JoinButton from '../components/JoinButton.vue';
export default {
    components: {
        JoinButton
    },
    data() {
        return {
            newUser: '',
            code: '',
            loadingNewGame: false,
        }
    },
    methods: {
        findGame() {
            if (this.newUser === '' || this.code === '') return;
            this.$root.$emit('loading-join', true);
            this.$root.player.name = this.newUser.toUpperCase();
            // Find the game in the DB
            axios.get('/api/play/' + this.code.toLowerCase()).then(response => {
                console.log('Found existing game:', response.data);
                this.join(response.data);
            });
        },
        start() {
            if (this.newUser === '') return;
            this.loadingNewGame = true;
            this.$root.player.name = this.newUser.toUpperCase();
            // Get game ID from server
            axios.post('/api/play/new').then(response => {
                console.log('Registered new game:', response.data);
                this.join(response.data);
            });
        },
        join(game) {
            this.$root.join(game).then(() => {
                this.$router.push({ name: 'app', params: { gameCode: game.code }});
                this.loadingNewGame = false;
                this.$root.$emit('loading-join', false);
            });
        }
    }
}
</script>

<style lang="scss" scoped>
.or {
    text-align: center;
    display: flex;
    flex-direction: column;
    justify-content: center;
    letter-spacing: 0;
}
</style>

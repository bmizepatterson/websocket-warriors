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
                    <div class="input-group-prepend">
                        <button class="btn btn-primary" @click="findGame">Join Game:</button>
                    </div>
                    <label for="game-code" class="sr-only">Game code</label>
                    <input id="game-code" class="form-control" placeholder="Game code" v-model="code" @keyup.enter="findGame">
                    <font-awesome-icon v-if="loadingGame" icon="cog" class="loading-icon" pulse />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            newUser: '',
            code: '',
            loadingNewGame: false,
            loadingGame: false,
        }
    },
    computed: {
        player() {
            return {
                name: this.newUser.toUpperCase(),
                score: 0,
            }
        }
    },
    methods: {
        findGame() {
            if (this.newUser === '' || this.code === '') return;
            this.loadingGame = true;
            // Find the game in the DB
            axios.get('/api/play/' + this.code.toLowerCase()).then(response => {
                console.log('Found existing game:', response.data);
                this.join(response.data);
            });
        },
        start() {
            if (this.newUser === '') return;
            this.loadingNewGame = true;
            // Get game ID from server
            axios.post('/api/play/new').then(response => {
                console.log('Registered new game:', response.data);
                this.join(response.data);
            });
        },
        join(game) {
            this.$root.game = {
                id: game.id,
                code: game.code,
                created_at: game.created_at,
                updated_at: game.updated_at,
            };
            axios.put('/api/play/' + game.id, this.player).then(response => {
                console.log('Registered ' + this.player.name + ' in game ' + game.code);
                console.log('Users in game ' + game.code + ':', response.data);
                this.$root.users = response.data;
                this.$root.player = response.data.filter(u => u.name === this.player.name)[0];
                this.$router.push({ name: 'app', params: { gameCode: game.code }});
                this.loadingNewGame = this.loadingGame = false;
            })
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
.loading-icon {
    position: absolute;
    top: 11px;
    right: 1rem;

    .form-control ~ & {
        color: $primary;
    }
}
</style>

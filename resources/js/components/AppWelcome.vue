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
                <button class="btn btn-block btn-primary" @click="start">New Game</button>
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
        }
    },
    computed: {
        player() {
            return {
                name: this.newUser,
                score: 0,
            }
        }
    },
    methods: {
        findGame() {
            if (this.newUser === '' || this.code === '') return;
            // Find the game in the DB
            axios.get('api/play/' + self.code).then(response => {
                console.log('Found existing game:', response.data);
                this.join(response.data);
            });
        },
        start() {
            if (this.newUser === '') return;
            // Get game ID from server
            axios.post('/api/play/new', {
                name: this.newUser,
                score: 0,
            }).then(response => {
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
            this.$root.users = game.users;
            this.$root.player = game.users.filter(u => u.name === this.player.name)[0];
            this.$router.push({ name: 'app', params: { gameCode: game.code }});
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

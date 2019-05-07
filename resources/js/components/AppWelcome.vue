<template>
    <div class="text-center">
        <h1 class="display-1 m-0 pb-5">WEBSOCKET WARRIORS</h1>
        <div class="row pt-5 justify-content-center">
            <div class="col-sm-6">
                <label for="name" class="sr-only">Your name</label>
                <input id="name" class="form-control" placeholder="YOUR NAME" v-model="newUser">
            </div>
        </div>

        <div class="row no-gutters p-5">
            <div class="col-sm-3">
                <button class="btn btn-block btn-primary" @click="join">NEW GAME</button>
            </div>
            <div class="col-sm-2 or">
                -&nbsp;OR&nbsp;-
            </div>
            <div class="col-sm-7">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <button class="btn btn-primary" @click="join">JOIN GAME:</button>
                    </div>
                    <label for="game-code" class="sr-only">Game code</label>
                    <input id="game-code" class="form-control" placeholder="GAME CODE" v-model="code">
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
    methods: {
        join() {
            if (this.newUser === '') return ;
            this.$root.users.push({
                name: this.newUser,
                score: 0,
            });
            this.$router.push({ name: 'app' });
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

<template>
    <div class="welcome-banner text-center p-5">
        <h1 class="display-1">Websocket Warriors</h1>
        <input class="form-control" placeholder="Your name" v-model="newUser">
        <button class="btn btn-primary" @click="join">Join</button>
    </div>
</template>

<script>
export default {
    data() {
        return {
            newUser: ''
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

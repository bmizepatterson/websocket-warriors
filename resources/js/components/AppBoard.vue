<template>
    <div class="board p-2">
        <div class="messages p-2 border">
            <p v-for="(message, index) in messages" :key="index" :class="{ 'mb-0': index === $root.users.length - 1 }">{{ message.text }}</p>
        </div>
        <div class="new-message pt-2">
            <input class="form-control border" v-model="newMessage" @keyup.enter="send">
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            messages: [],
            newMessage: '',
        }
    },
    mounted() {
        if (this.$root.users.length < 2) {
            this.messages.push({
                text: 'Welcome to the chat room. You are the only one here.',
            });
        }
        this.getMessages();
    },
    methods: {
        send() {
            axios.post('/api/play/' + this.$root.game.id + '/messages', {
                message: this.newMessage,
                user: this.$root.player,
            }).then(response => {
                this.messages.push(response.data);
                this.newMessage = '';
            });
        },
        getMessages() {
            axios.get('/api/play/' + this.$root.game.id + '/messages').then(response => {
                response.data.forEach(m => this.messages.push(m));
            })
        }
    }
}
</script>

<style lang="scss" scoped>
.board {
    width: 600px;
    background-color: $gray-100;
    position: relative;
    z-index: 1;
    box-shadow: 10px 0 5px -5px black;
    display: flex;
    flex-direction: column;
    font-family: sans-serif;
    color: black;
    letter-spacing: initial;
    word-spacing: initial;
    font-size: 1rem;
    text-transform: initial;
}
.messages {
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
}
.new-message {
    flex-grow: 0;
    .form-control {
        text-transform: initial;
    }
}
</style>
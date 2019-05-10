<template>
    <div class="board p-2">
        <div class="messages border">
            <div class="messages-wrapper p-2" ref="messagesWrapper">
                <div v-for="(message, index) in messages" :key="index" class="message" :class="{ 'system-message': message.system }">
                    <p v-if="message.user" class="mb-0 font-weight-bold">{{ message.user.name }}</p>
                    <p v-if="message.system" v-html="message.text"></p>
                    <p v-else>{{ message.text }}</p>
                </div>
            </div>
            <div v-for="(user, index) in typingUsers" :key="index" class="message system-message">
                <p><span class="user-name">{{ user.name }}</span><img src="/storage/typing.gif" width="24" height="24" /></p>
            </div>
        </div>
        <div class="new-message pt-2">
            <input class="form-control border" v-model="newMessage" @keydown="startTyping" @keyup.enter="send" v-focus>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            messages: [],
            newMessage: '',
            typingUsers: [],
        }
    },
    mounted() {
        if (this.$root.users.length < 2) {
            this.messages.push({
                system: true,
                text: 'Welcome to the chat room. You are the only one here.',
            });
        }
        this.getMessages();
        Echo.channel('game.' + this.$root.game.id)
            .listen('UserJoined', (e) => {
                this.messages.push({
                    system: true,
                    text: `<span class="user-name">${e.user.name}</span> has joined the room.`
                });
            })
            .listen('UserLeft', (e) => {
                this.messages.push({
                    system: true,
                    text: `<span class="user-name">${e.user.name}</span> has left the room.`
                });
            })
            .listen('NewMessage', (e) => {
                this.messages.push(e.message);
            })
            .listenForWhisper('typingStarted', (user) => {
                if (this.typingUsers.findIndex(u => u.id === user.id) > -1) {
                    this.typingUsers.push(user);
                }
            });
    },
    methods: {
        send() {
            this.messages.push({
                text: this.newMessage,
                user: {
                    name: this.$root.player.name,
                }
            });
            const message = this.newMessage;
            this.newMessage = '';
            axios.post('/api/play/' + this.$root.game.id + '/messages', {
                message: message,
                user: this.$root.player,
            }).then(response => {
                this.messages.splice(-1, 1, response.data);
                this.$refs.messagesWrapper.scrollTop = this.$refs.messagesWrapper.scrollHeight;
            });
        },
        getMessages() {
            axios.get('/api/play/' + this.$root.game.id + '/messages').then(response => {
                response.data.forEach(m => this.messages.push(m));
                this.$refs.messagesWrapper.scrollTop = this.$refs.messagesWrapper.scrollHeight;
            })
        },
        startTyping() {
            this.whisperTypingStarted();
        },
        whisperTypingStarted() {
            // Echo.channel(this.$root.channel)
            //     .whisper('typingStarted', {
            //         user: this.$root.player,
            //     })
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
    font-size: 0.9rem;
    text-transform: initial;
}
.messages {
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;

    .messages-wrapper {
        height: 100%;
        overflow: auto;
    }

    .message:last-of-type p:last-of-type {
        margin-bottom: 0;
    }

    .system-message {
        font-style: italic;
    }
}
.new-message {
    flex-grow: 0;
    .form-control {
        text-transform: initial;
        font-size: 0.9rem;
    }
}
</style>

<template>
    <div class="board p-2">
        <div class="messages border">
            <div class="messages-wrapper p-2" ref="messagesWrapper">
                <div v-for="(message, index) in messages" :key="index" class="message" :class="{ 'system-message': message.system }">
                    <p v-if="message.user" class="mb-0 font-weight-bold user-name">{{ message.user.name }}</p>
                    <p v-if="message.system" v-html="message.text"></p>
                    <p v-else>{{ message.text }}</p>
                </div>
                <div v-for="user in typingUsers" :key="user.id" class="message system-message">
                    <transition name="fade">
                        <p><span class="user-name">{{ user.name }}</span><typing-indicator class="ml-1" /></p>
                    </transition>
                </div>
            </div>
        </div>
        <div class="new-message pt-2">
            <input class="form-control border" v-model="newMessage" @keydown="startTyping" @keyup.enter="send" v-focus>
        </div>
    </div>
</template>

<script>
import _ from 'lodash';
import TypingIndicator from '../components/TypingIndicator.vue';

export default {

    components: {
        TypingIndicator,
    },

    data() {
        return {
            messages: [],
            newMessage: '',
            typingUsers: [],
            startTyping: null
        }
    },

    created() {
        this.startTyping = _.throttle(() => {
            axios.post('/api/play/' + this.$root.game.id + '/user/' + this.$root.player.id + '/typing')
        }, 500)

        if (this.$root.users.length < 2) {
            this.messages.push({
                system: true,
                text: 'Welcome to the chat room. You are the only one here.',
            });
        }
        this.getMessages();
        Echo.channel(this.$root.channel)
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
                this.scrollToBottom();
            })
            .listen('UserTyping', e => {
                console.log('Received typing Echo:', e);
                let index = this.typingUsers.findIndex(u => u.id === e.userId);
                // If they are typing, and they're not already typing, add them.
                if (e.typing) {
                    if (index < 0) {
                        console.log('Adding user ' + e.userId + ' to typing users');
                        this.typingUsers.push(this.$root.users.filter(u => u.id === e.userId)[0]);
                        index = this.typingUsers.length - 1;
                    }
                    setTimeout(() => {
                        this.typingUsers.splice(index, 1);
                    }, 1000);
                }
                // They aren't typing, and they were typing, remove them.
                // if (!e.typing && index > -1) {
                //     this.typingUsers.splice(index, 1);
                // }
            });    
    },

    methods: {
        send() {
            if (this.newMessage === '') return;
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
            });
            this.scrollToBottom();
        },
        getMessages() {
            axios.get('/api/play/' + this.$root.game.id + '/messages').then(response => {
                response.data.forEach(m => this.messages.unshift(m));
                this.$refs.messagesWrapper.scrollTop = this.$refs.messagesWrapper.scrollHeight;
            })
        },
        scrollToBottom() {
            this.$nextTick(() => {
                this.$refs.messagesWrapper.scrollTop = this.$refs.messagesWrapper.scrollHeight;
            });
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

    .message p {
        word-wrap: break-word;
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

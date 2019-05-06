<template>
    <div class="app row no-gutters" style="height: 600px;">
        <span class="status-bar">Status: {{ status }}</span>    
        <div class="board">
            <button id="test-button" class="btn btn-secondary">Click me</button>
        </div>

        <div class="player-list">
            <ul class="list-group">
                <li class="list-group-item">Player 1 <span class="badge badge-primary float-right">10</span></li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            socket: null,
            status: 'Disconnected',
            users: [],
        }
    },

    created() {
        const self = this;

        self.socket = new WebSocket('ws://localhost:8000/app/laravel-websocket-warriors')

        self.socket.onerror = (error) => {
            self.$refs.status = 'Error';
            console.error('Websocket error: ' + error);
        }

        self.socket.onopen = () => self.$refs.status = 'Connected';

        self.socket.onclose = () => self.$refs.status = 'Disconnected';
    },

}
</script>

<style scoped>
.status-bar {
    font-size: 90%;
    position: absolute;
    bottom: 0;
    left: 5px;
}
</style>
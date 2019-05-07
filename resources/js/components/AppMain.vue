<template>
    <div class="app row no-gutters" style="height: 600px;">
        <div class="board">
        </div>

        <div class="player-list">
            <ul class="list-group">
                <li v-for="user in $root.users" :key="user.name" class="list-group-item">
                    {{ user.name }}
                    <span class="add" @click="updateScore(user)">+</span>
                    <span class="badge badge-primary float-right">{{ user.score }}</span>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
        }
    },

    created() {
        const self = this;

        Echo.channel('game')
            .listen('UserScoreUpdated', (e) => {
                self.score = e.score;
            });
    },

    methods: {
        updateScore(user) {
            const self = this;

            const payload = {
                user: user.name,
                score: user.score += 10,
            }

            axios.post('/app', payload).then(response => {
                console.log(response);
            });
        }
    }

}
</script>

<style scoped>
.add {
    display: inline-block;
    width: 20;
    height:20;
    color: black;
    background-color:white;
    border-radius:100%;
    cursor: pointer;
    vertical-align: middle;
    text-align:center;
    margin-left: 5px;
}
</style>

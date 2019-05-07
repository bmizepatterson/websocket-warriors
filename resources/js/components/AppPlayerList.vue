<template>
    <div class="player-list">
        <ul class="list-group">
            <li v-for="user in $root.users" :key="user.name" class="list-group-item border-0">
                {{ user.name }}
                <span class="float-right">{{ user.score }}</span>
            </li>
        </ul>
    </div>
</template>

<script>
export default {

}
</script>

<style lang="scss" scoped>
.player-list {
    width: 300px;
    background-color: $primary;
    letter-spacing: 0;

    .list-group-item {
        background: transparent;
        border-radius: 0;
        transition: background-color 0.2s;

        &:hover {
            background: darken($primary, 10%);
        }
    }

    .badge {
        font-size: inherit;
    }
}
</style>
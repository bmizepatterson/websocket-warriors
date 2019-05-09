<template>
    <button class="btn btn-primary px-5" @click="$emit('click')">
        <slot>Join</slot>
        <font-awesome-icon v-if="loading" icon="cog" class="loading-icon" pulse />
    </button>
</template>

<script>
export default {
    data() {
        return {
            loading: false,
        }
    },
    mounted() {
        this.$root.$on('loading-join', (loading) => this.loading = loading);
    }
}
</script>

<style lang="scss" scoped>
.loading-icon {
    position: absolute;
    top: 11px;
    right: 1rem;

    .form-control ~ & {
        color: $primary;
    }
}
</style>
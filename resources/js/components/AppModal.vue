<template>
    <transition name="modal">
        <div class="app-modal-mask">
            <div class="app-modal-container">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="$emit('close')">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="app-modal-header">
                    <slot name="header"></slot>
                </div>

                <div class="app-modal-body">
                    <slot name="body"></slot>
                </div>

                <div class="app-modal-footer">
                    <slot name="footer">
                    </slot>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
export default {
}
</script>

<style lang="scss">
.app-modal-mask {
    position: fixed;
    z-index: 9998;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, .7);
    display: flex;
    flex-direction: column;
    justify-content: center;
    transition: opacity .3s ease;
}

.app-modal-container {
    margin: 0px auto;
    padding: 20px 30px;
    background-color: $gray-100;
    box-shadow: $shadow-drama;
    transition: all .3s ease;
    font-family: sans-serif;
    color: black;
    letter-spacing: initial;
    word-spacing: initial;
    text-transform: none;
}

.app-modal-body {
    margin: 20px 0;
}

.app-modal-header {
    font-family: inherit;
}

/*
 * The following styles are auto-applied to elements with
 * transition="modal" when their visibility is toggled
 * by Vue.js.
 *
 * You can easily play with the modal transition by editing
 * these styles.
 */

.modal-enter {
    opacity: 0;
}

.modal-leave-active {
    opacity: 0;
}

.modal-enter .modal-container,
.modal-leave-active .modal-container {
    -webkit-transform: scale(1.1);
    transform: scale(1.1);
}

</style>
<template>
    <span class="sc-typing-indicator">
        <span></span>
        <span></span>
        <span></span>
    </span>
</template>

<script>
export default {
}
</script>

<style scoped>
.sc-typing-indicator span {
    display: inline-block;
    background-color: #b6b5ba;
    width: 5px;
    height: 5px;
    border-radius: 100%;
    animation: bob 2s infinite;
}
/* SAFARI GLITCH */
.sc-typing-indicator span:nth-child(1) {
    animation-delay: -1s;
}
.sc-typing-indicator span:nth-child(2) {
    animation-delay: -0.85s;
}
.sc-typing-indicator span:nth-child(3) {
    animation-delay: -0.7s;
}
@keyframes bob {
    10% {
        transform: translateY(-10px);
        background-color: #9e9da2;
    }
    50% {
        transform: translateY(0);
        background-color: #b6b5ba;
    }
}
</style>
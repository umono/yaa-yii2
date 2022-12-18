<template>
    <div class="not-found">
        <css-doodle class="bg">
            @grid: 16 / 320px;
            @size: 1px calc(141.4% + 1px);
            transform: rotate(@p(±45deg));
            background: #AEACFB;
            margin: auto;
        </css-doodle>
        <span class="label">404</span>
    </div>
</template>

<script lang="ts">
import 'css-doodle';
export default {
    setup() {
        return {}
    }
}
</script>

<style lang="scss" scoped>
.not-found {
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;

    .bg {
        position: absolute;
        width: 350px;
        height: 350px;
    }

    .label {
        font-size: 33px;
        font-weight: 700;
    }
}
</style>
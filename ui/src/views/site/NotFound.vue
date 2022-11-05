<template>
    <div class="not-found">
        <css-doodle class="bg">
            @grid: 50x1 / 100%;

            @place: center;
            @size: calc(75% / @I * @i);

            transform: rotate(calc(@i * 5deg));

            border-radius: 30%;
            border: 1px solid hsla(
            calc(10 + 4 * @i), 70%, 68%, @r.8
            );
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
    background: white;
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
<template>
    <div class="tag-box"  :class="isborder == false ?'no-border':'tag-box'">
        {{title}}
    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'

export default defineComponent({
    props:['title','isborder'],
    setup () {
        return {}
    }
})
</script>

<style lang="scss" scoped>
    .tag-box{
        padding:6px 16px;
        background:#ffffff20;
        border-radius: 16px;
        display: inline-block;
        align-items: center;
        text-align: center;
    }
    .no-border{
        border: 1px solid #e6e6e6;
        background:#f9fdf9;
    }
</style>
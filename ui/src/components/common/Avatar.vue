<template>
    <div class="avatar" :class="(isShadow == false ? 'no-shadow' : '') + (fillet == true ? 'fillet' : '')">
        <n-image :src="src" fallback-src="https://inews.gtimg.com/newsapp_bt/0/14751264257/1000" object-fit="cover" lazy
            :preview-disabled="true" />
        <div class="label" v-if="showLabel == true"></div>
    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'

export default defineComponent({
    props: ['src', 'isShadow', 'fillet', 'showLabel'],
})
</script>

<style lang="scss" scoped>
.avatar {
    width: 50px;
    height: 50px;
    box-shadow: $boxShadow;
    border: 3px solid rgb(255, 255, 255);
    border-radius: 13px;
    position: relative;
    z-index: 1;

    :deep(.n-image) {
        width: 100%;
        height: 100%;
    }

    :deep(img) {
        width: 100%;
        height: 100%;
        border-radius: 10px;
    }

    .label {
        position: absolute;
        width: 12px;
        height: 12px;
        right: -8px;
        top: -8px;
        z-index: 2;
        border-radius: 100%;
        border: 3px solid rgb(255, 255, 255);
        background: #52b260;
    }
}

.no-shadow {
    box-shadow: none !important;
}

.fillet {
    border-radius: 100%;
}
</style>
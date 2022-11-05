<template>
    <n-button @click="test">测试</n-button>
    <NumberJump v-model:number="number" />
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue';
import NumberJump from "@/components/common/numberJump/index.vue";
import { random } from "@/plugins/lodash"
export default defineComponent({
    name: "USER",
    components: {
        NumberJump,
    },
    setup() {
        const number = ref(0);

        const test = () => {
            const _num = random(3000, 99999);
            console.log('go', _num);
            number.value = _num;
        }
        return {
            number,
            test
        }
    }
})
</script>

<style lang="scss" scoped>

</style>
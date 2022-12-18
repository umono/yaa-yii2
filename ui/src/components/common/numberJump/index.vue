<template>
    <div class="jump-number-box">
        <span class="inline-block ">
            <div class="ticker-view" style="transform: none; transform-origin: 50% 50% 0px;">
                <numberJump v-for="(item, key) in 10" v-model:number="numberValue[key]" :index="key"
                    :class="'sort-' + key">
                </numberJump>
            </div>
        </span>
    </div>

</template>

<script lang="ts">
import { defineComponent, Ref, ref } from 'vue';
import numberJump from './box.vue';
export default defineComponent({
    props: ['number'],
    components: { numberJump },
    setup(props) {
        let numberValue: any = ref([0]);
        const initNumberValue = (n: any) => {
            const _n = n.toString();
            const arr = [];
            for (let index = 0; index < _n.length; index++) {
                arr.push(_n[index])
            }
            numberValue.value = arr;
        }
        if (props.number) {
            initNumberValue(props.number);
        }

        watch(() => props.number, initNumberValue)

        return {
            numberValue,
            initNumberValue
        }
    }
})
</script>

<style lang="scss" scoped>
.jump-number-box{
    line-height: 2.5rem;
    overflow: hidden;
}
.inline-block {
    display: inline-block;
}

.ticker-view {
    height: 100%;
    margin: auto;
    display: flex;
    // flex-direction: row-reverse;
    overflow: hidden;
    position: relative;
}
</style>
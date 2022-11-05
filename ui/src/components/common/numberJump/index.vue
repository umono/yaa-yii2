<template>
    <div class="jump-number-box">
        <h1>
            <span class="font-200 inline-block ">
                <div class="ticker-view" style="transform: none; transform-origin: 50% 50% 0px;">
                    <numberJump v-for="(item, key) in 10" v-model:number="numberValue[key]" :index="key"
                        :class="'sort-' + key">
                    </numberJump>
                </div>
            </span>
        </h1>
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
        watch(() => props.number, (n) => {
            const _n = n.toString();
            const arr = [];
            for (let index = 0; index < _n.length; index++) {
                arr.push(_n[index])
            }
            numberValue.value = arr;
        })

        return {
            numberValue,
        }
    }
})
</script>

<style lang="scss" scoped>
h1 {
    line-height: 2.5rem;
}

.font-200 {
    font-weight: 200;
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
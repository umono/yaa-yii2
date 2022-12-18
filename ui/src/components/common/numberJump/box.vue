<template>
    <div class="ticker-column-container">
        <div class="ticker-column" :style="`transform: translateY(${number}px) translateZ(00px);`">
            <div class="ticker-digit"><span>9</span></div>
            <div class="ticker-digit"><span>8</span></div>
            <div class="ticker-digit"><span>7</span></div>
            <div class="ticker-digit"><span>6</span></div>
            <div class="ticker-digit"><span>5</span></div>
            <div class="ticker-digit"><span>4</span></div>
            <div class="ticker-digit"><span>3</span></div>
            <div class="ticker-digit"><span>2</span></div>
            <div class="ticker-digit"><span>1</span></div>
            <div class="ticker-digit"><span>0</span></div>
        </div><span class="number-placeholder">0</span>
    </div>
</template>

<script lang="ts">
import {throttle} from '@/plugins/lodash';
import { defineComponent, onUnmounted, ref, watch } from 'vue';

export default defineComponent({
    props: ['number', 'index', 'numberArr'],
    setup(props) {
        const index = props.index;
        const number = ref(-40);


        let setInterVal1: any = null;
        let setInterVal2: any = null;


        const go = throttle(async (n) => {
            const tfNumber = n * 40;
            number.value = -30;
            setInterVal1 = setInterval(() => {
                number.value += 6;
                if (number.value > tfNumber + 30) {
                    setInterVal2 = setInterval(() => {
                        number.value -= 1;
                        if (number.value <= tfNumber) {
                            number.value = tfNumber;

                            clearInterval(setInterVal2);
                        }
                    }, 1)
                    clearInterval(setInterVal1);
                }
            }, 1)
        }, 500, {
            leading: true,
            trailing: false
        })

        if (props.number) {
            go(props.number);
        }

        watch(() => props.number, go);

        onUnmounted(() => {
            go.cancel();
            clearInterval(setInterVal1);
            clearInterval(setInterVal2);
        })

        return {
            number,
        }
    },
})
</script>

<style lang="scss" scoped>
.ticker-column-container {
    position: relative;
}

.ticker-column {
    position: absolute;
    height: 1000%;
    bottom: 0;
}

.ticker-digit {
    height: 10%;
}

.ticker-column {
    // -webkit-animation: pulseGreen 0.5s cubic-bezier(0.4, 0, 0.6, 1) 1;
    // animation: pulseGreen 0.5s cubic-bezier(0.4, 0, 0.6, 1) 1;
}

.number-placeholder {
    visibility: hidden;
}


// @-webkit-keyframes pulseGreen {

//     0%,
//     to {
//         color: #fff;
//     }

//     50% {
//         --tw-text-opacity: 1;
//         color: rgba(163, 163, 163);
//     }
// }

// @keyframes pulseGreen {

//     0%,
//     to {
//         color: #fff;
//     }

//     50% {
//         --tw-text-opacity: 1;
//         color: rgba(163, 163, 163);
//     }
// }
</style>
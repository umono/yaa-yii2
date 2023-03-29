<template>
    <div class="p-4">
        <div class="text-xl my-7">
            👏 你好
        </div>
        <n-grid x-gap="16" :cols="24">
            <n-gi :span="15">
                <n-space>
                    <n-card class="item-box-shadow rounded-2xl">
                        <div>
                            <div class="flex w-64 justify-between">
                                <div class="text-5xl">
                                    🧑
                                </div>
                                <n-progress style="width: 55px;" type="circle" :offset-degree="180" :stroke-width="15"
                                    :percentage="20" color="#0057ff">
                                    <div style="word-break: normal;" class="text-xs font-bold">+20%</div>
                                </n-progress>
                            </div>
                            <div class="mt-2 text-xs text-slate-400">
                                新增用户数
                            </div>
                        </div>
                        <div class="mt-2">
                            <div class="text-xl font-bold">
                                +700
                            </div>
                            <div class="text-xs text-slate-400">过去7天</div>
                        </div>
                    </n-card>
                    <n-card class="item-box-shadow rounded-2xl">
                        <div>
                            <div class="flex w-64 justify-between">
                                <div class="flex">
                                    <div class="text-5xl">
                                        🍦
                                    </div>
                                    <div class="text-lg ml-2">冰淇淋</div>
                                </div>

                                <n-progress style="width: 55px;" type="circle" :offset-degree="180" :stroke-width="15"
                                    :percentage="75" color="#52b260">
                                    <div style="word-break: normal;" class="text-xs font-bold">+75%</div>
                                </n-progress>
                            </div>
                            <div class="mt-2 text-xs">
                                商品交易最多数量
                            </div>
                        </div>
                        <n-space class="flex mt-2">
                            <div>
                                <div class="text-xs text-slate-400">
                                    周单量
                                </div>
                                <div class="text-xl font-bold">
                                    <NumberJump style="height:28px" :number="452" />
                                </div>
                            </div>
                            <div class="">
                                <div class="text-xs text-slate-400">
                                    月单量
                                </div>
                                <div class="text-xl font-bold">
                                    <NumberJump style="height:28px" :number="1536" />
                                </div>
                            </div>
                        </n-space>
                    </n-card>
                </n-space>

                <div class="mt-12">
                    <div class="text-xl mb-3">
                        🥇 统计
                    </div>
                    <n-space>
                        <n-card class="item-box-shadow  rounded-xl" size="small">
                            <div class="flex rounded-md w-52">
                                <div class="bg-blue-600 rounded-md w-11">
                                </div>
                                <div class="pl-3">
                                    <div class="text-lg font-bold">$35.2K</div>
                                    <div class="text-xs">
                                        总销售金额
                                    </div>
                                </div>
                            </div>
                        </n-card>

                        <n-card class="item-box-shadow cursor-pointer rounded-xl" size="small">
                            <div class="flex rounded-md w-52">
                                <div class="bg-green-500 rounded-md w-11">
                                </div>
                                <div class="pl-3">
                                    <div class="text-lg font-bold">1.2K</div>
                                    <div class="text-xs text-slate-400">
                                        总产品数量
                                    </div>
                                </div>
                            </div>
                        </n-card>
                    </n-space>
                </div>

                <div class="mt-5">
                    <div id="container1" />
                </div>
            </n-gi>
            <n-gi :span="8">
                <n-card class="item-box-shadow rounded-2xl">
                    <div class="mb-1">
                        受欢迎的商品
                    </div>
                    <div class="text-2xl font-bold mb-1">
                        $10,302,402
                    </div>
                    <div class="mt-5" id="container2" />
                </n-card>


                <n-card class="item-box-shadow rounded-2xl mt-20">
                    <div class="text-lg font-bold mb-4">活跃用户</div>
                    <div class="w-full h-12 flex mt-2">
                        <div class="bg-green-500 rounded-md w-11 h-11">
                        </div>
                        <div class="pl-4">
                            <div class="font-bold">用户1</div>
                            <div class="text-slate-400">///.....</div>
                        </div>
                    </div>
                    <div class="w-full h-12 flex mt-2">
                        <div class="bg-blue-300 rounded-md w-11 h-11">
                        </div>
                        <div class="pl-4">
                            <div class="font-bold">用户1</div>
                            <div class="text-slate-400">///.....</div>
                        </div>
                    </div>
                    <div class="w-full h-12 flex mt-2">
                        <div class="bg-red-300 rounded-md w-11 h-11">
                        </div>
                        <div class="pl-4">
                            <div class="font-bold">用户1</div>
                            <div class="text-slate-400">///.....</div>
                        </div>
                    </div>
                </n-card>
            </n-gi>
        </n-grid>
    </div>
</template>

<script lang="ts">


import { defineComponent, ref } from 'vue';
import NumberJump from "@/components/common/numberJump/index.vue";
import { Chart } from "@antv/g2";
export default defineComponent({
    name: "USER",
    components: {
        NumberJump,
    },
    setup() {
        const chart1 = () => {
            const chart = new Chart({
                container: "container1",
            });
            chart
                .point()
                .data({
                    type: 'fetch',
                    value:
                        'https://gw.alipayobjects.com/os/basement_prod/6b4aa721-b039-49b9-99d8-540b3f87d339.json',
                })
                .encode('x', 'height')
                .encode('y', 'weight')
                .encode('color', 'gender')
                .scale('color', {
                    range: ['#0057ff', '#22c55e'],
                });

            chart.render();
        }
        const chart2 = () => {
            const data = [
                {
                    name: '苹果',
                    value: 50,
                    sum: 3355043
                },
                {
                    name: '西瓜',
                    value: 5.5,
                    sum: 1695782
                },
                {
                    name: '葡萄',
                    value: 21.3,
                    sum: 1113852
                },
                {
                    name: '苹果1',
                    value: 50,
                    sum: 3355043
                },
                {
                    name: '西瓜1',
                    value: 5.5,
                    sum: 1695782
                },
                {
                    name: '葡萄1',
                    value: 21.3,
                    sum: 1113852
                }
            ]

            const chart = new Chart({
                container: 'container2',
                width: 350,
                height: 200
            });
            chart.axis('y', false);
            chart
                .interval()
                .data(data)
                .encode('x', 'name')
                .encode('y', 'value')
                .encode('color', 'name')
                .encode('size', 10)
                .style('radiusTopLeft', 10)
                .style('radiusTopRight', 10)

            chart.render();

        }

        onMounted(chart1);
        onMounted(chart2);
        return {

        }
    },
})
</script>

<style lang="scss" scoped>
.item-box-shadow {
    box-shadow: 0 8px 18px rgb(0 0 0 / 6%);
}

.item-shadow-lg {
    border-color: #2080f0;
    box-shadow: #2080f0 0 10px 30px -10px;
}
</style>
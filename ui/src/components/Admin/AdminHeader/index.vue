<template>
    <n-card class="header-box">
        <n-space>
            <!-- <n-button strong secondary circle @click="toggleTheme('moon')" v-if="theme == null">
                <template #icon>
                    <n-icon>
                        <WeatherMoon24Regular />
                    </n-icon>
                </template>
            </n-button>
            <n-button strong secondary circle @click="toggleTheme('')" v-else>
                <template #icon>
                    <n-icon>
                        <WeatherSunny24Regular />
                    </n-icon>
                </template>
            </n-button> -->
            <n-tooltip placement="top-start" trigger="hover">
                <template #trigger>
                    <n-button strong secondary circle @click="reload">
                        <template #icon>
                            <n-icon>
                                <RefreshRound />
                            </n-icon>
                        </template>
                    </n-button>
                </template>
                刷新页面
            </n-tooltip>
            <n-button strong secondary circle @click="toggleShowTabs">
                <template #icon>
                    <n-icon>
                        <CalendarWeekStart24Regular v-if="showTabs" />
                        <BroadActivityFeed16Regular v-else />
                    </n-icon>
                </template>
            </n-button>
        </n-space>
    </n-card>
</template>

<script lang="ts">
import { defineComponent, inject, computed } from 'vue'
import { RefreshRound } from '@vicons/material';
import {
    WeatherSunny24Regular, WeatherMoon24Regular, PositionForward24Filled, PositionBackward24Filled,
    BroadActivityFeed16Regular, CalendarWeekStart24Regular, CheckboxUnchecked20Regular
} from '@vicons/fluent';
import { Icon } from '@vicons/utils';
import { useStore } from 'vuex';

export default defineComponent({
    components: {
        Icon, RefreshRound, WeatherMoon24Regular, WeatherSunny24Regular, PositionForward24Filled,
        PositionBackward24Filled, BroadActivityFeed16Regular,
        CalendarWeekStart24Regular, CheckboxUnchecked20Regular
    },
    setup() {
        const reload = inject("reload")
        const store = useStore()
        let theme = computed(() => {
            return store.getters['theme/getTheme'];
        })
        let haveFroward = computed(() => {
            return store.getters['theme/getHaveForward'];
        })

        const showTabs = computed(() => {
            return store.getters['adminNavStore/getShowTabs'];
        })
        return {
            reload,
            theme,
            haveFroward,
            showTabs,
            toggleShowTabs() {
                store.dispatch('adminNavStore/setShowTabs')
            }
        }
    },
    methods: {
        toggleTheme(type: string) {
            this.$store.dispatch("theme/toggle", type);
        },
        toggleLanguage(language: string) {
            this.$store.dispatch("theme/toggleLanguage", language);
        },
    }
})
</script>

<style lang="scss" scoped>
.header-box {
    height: 80px;
    // display: flex;
    // align-items: center;
    // padding: 0 32px;
    border-left: none;
    border-right: none;
    border-top: none;
}
</style>
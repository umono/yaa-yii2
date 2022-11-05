<template>
    <n-layout has-sider class="page">
        <LeftMenu />
        <n-layout class="content-page-box">
            <AdminHeader />
            <transition name="fade" mode="out-in">
                <AdminHeaderTab v-show="showTabs === true" />
            </transition>
            <router-view v-slot="{ Component }">
                <transition name="fade" mode="out-in">
                    <div>
                        <keep-alive v-if="isRouterAlive">
                            <component :is="Component" />
                        </keep-alive>
                    </div>
                </transition>
            </router-view>
        </n-layout>
    </n-layout>
</template>

<script lang="ts">
import AdminLeftMenu from "./leftMenu/index.vue";
import AdminHeader from "./AdminHeader/index.vue";
import AdminHeaderTab from "./AdminHeader/tab.vue";
import { defineComponent, ref, provide, computed } from 'vue'
import { useStore } from "vuex";
export default defineComponent({
    components: {
        AdminHeader,
        AdminHeaderTab,
        AdminLeftMenu,
    },
    setup() {
        const store = useStore()
        let isRouterAlive = ref(true)
        const reload = () => {
            isRouterAlive.value = false;
            setTimeout(() => {
                isRouterAlive.value = true;
            }, 100)
        }
        const showTabs = computed(() => {
            return store.getters['adminNavStore/getShowTabs'];
        })
        provide("reload", reload)
        return {
            isRouterAlive,
            showTabs
        }
    },
})
</script>

<style lang="scss" scoped>
// .page {
//     height: 100vh;
//     font-size: $fontSize;

//     .n-layout-sider__border {
//         display: none !important;
//     }
// }

// .content-page-box {
// overflow-y: auto !important;
// background: #f1f5f9;
// background: -webkit-linear-gradient(to right, #f7f3fb, #f7f9fc, #f3f9fd);
// background: linear-gradient(to right, #f7f3fb, #f7f9fc, #f3f9fd);

// :deep(.n-layout-scroll-container) {
// padding: 0 32px;
// padding-top: 75px;
// }
// }

/* 过度动画 */
.fade-enter-active {
    transition: all 0.1s ease-out;
}

.fade-leave-active {
    transition: all 0.1s cubic-bezier(1, 0.5, 0.8, 1);
}

.fade-enter-from,
.fade-leave-to {
    transform: translate(-20%, 0);
    opacity: 0;
}
</style>
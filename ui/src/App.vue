<template>
    <n-config-provider 
    preflight-style-disabled
    :inline-theme-disabled="false" :theme="theme" :theme-overrides="theme === null ? lightThemeOverrides : darkThemeOverrides" :locale="$store.state.theme.locale" :date-locale="$store.state.theme.dateLocale">
        <n-message-provider>
            <MessageApi />
        </n-message-provider>
        <!-- <n-theme-editor> -->
        <router-view></router-view>
        <!-- </n-theme-editor> -->
        <n-global-style />
    </n-config-provider>
</template>

<script lang="ts">
    import { computed, defineComponent, ref } from 'vue'
    import type { NLocale, NDateLocale, } from 'naive-ui';

    import MessageApi from "@/components/common/message-api.vue";
    import darkThemeOverrides from "@/styles/theme/dark";
    import lightThemeOverrides from "@/styles/theme/light";
    import { useStore } from "vuex";

    export default defineComponent({
        components: { MessageApi },
        setup() {
            const store = useStore()

            let theme = computed(() => {
                return store.getters['theme/getTheme'];
            })
            return {
                locale: ref < NLocale | null > (null),
                dateLocale: ref < NDateLocale | null > (null),
                darkThemeOverrides: darkThemeOverrides,
                lightThemeOverrides: lightThemeOverrides,
                theme,
            }
        },
        beforeCreate() {
            // 初始化读取主题
            this.$store.dispatch("theme/init");
            this.$store.dispatch('auth/initClientId');
            this.$store.dispatch('adminNavStore/initTabs');
        },
    })
</script>
<style lang="scss">
    #app {
        position: relative;
    }


    * {
        // font-family: "Arial", "Microsoft YaHei", sans-serif;
        font-family: "SF Pro SC", "SF Pro Display", "SF Pro Icons", "PingFang SC", "Helvetica Neue", "Helvetica", "Arial", sans-serif;
    }

    .n-modal-mask {
        // background: #1e3c7250 !important;
        // background:#f5f6f7 !important;
    }

    .n-modal {
        border-radius: 16px;
        position: relative;
        box-shadow: 0 1px 3px 0 rgb(0 0 0 / 8%);
        .n-card{
            border-radius: 16px; 
        }

        .n-card-header {
            margin-top: 20px;
            margin-bottom: 20px;

            .n-base-close {
                font-size: 17px;
                background: var(--n-close-color-hover);
                padding: 15px;
                position: absolute;
                top: 15px;
                right: 15px;
            }

            .n-base-close:hover {
                background: var(--n-close-color-hover);
                padding: 15px;
            }
        }

        .n-card-header__main {
            font-weight: 700 !important;
        }

        .n-card__footer {
            padding: 22px;
            background: var(--n-color-embedded-modal);
            align-items: center;
            border-bottom-left-radius: 16px;
            border-bottom-right-radius: 16px;

            .n-space {
                justify-content: flex-end !important;
            }
        }
    }

@import '@/styles/tailwind.css';
</style>
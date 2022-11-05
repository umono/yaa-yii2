<template>
    <div class="header-box">
        <Icon size="32" style="padding-right:12px;">
            <WeatherMoon24Regular @click="toggleTheme('moon')" v-if="theme == null" />
            <WeatherSunny24Regular @click="toggleTheme('')" v-else />
        </Icon>
        <n-button @click="toggleLanguage('en_US')" v-if="$store.state.theme.locale" style="margin-right:12px;">
            English
        </n-button>
        <n-button @click="toggleLanguage('zh-CN')" v-else style="margin-right:12px;">
            中文
        </n-button>
    </div>
</template>

<script lang="ts">
    import { WeatherSunny24Regular, WeatherMoon24Regular } from '@vicons/fluent';
    import { Icon } from '@vicons/utils';
    import { defineComponent, computed } from 'vue';
    import { useStore } from 'vuex';
    export default defineComponent({
        props: ["locale"],
        components: {
            WeatherSunny24Regular,
            WeatherMoon24Regular,
            Icon
        },
        setup() {
            const store = useStore()
            let theme = computed(() => {
                return store.getters['theme/getTheme'];
            })
            return {
                theme
            }
        },
        methods: {
            toggleTheme(type: string) {
                this.$store.dispatch("theme/toggle", type);
            },
            toggleLanguage(language: string) {
                this.$store.dispatch("theme/toggleLanguage", language);
            }
        }
    })
</script>

<style lang="scss" scoped>
    .header-box {
        height: 43px;
        padding: 20px;
        width: 1440px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: flex-end !important;

        .nav {
            display: flex;
            align-items: center;
            justify-content: flex-end !important;
        }
    }
</style>
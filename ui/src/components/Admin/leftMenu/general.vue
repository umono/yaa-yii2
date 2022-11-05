<template>
    <n-menu v-if="menuOptions.length > 0" class="menu-item" ref="menuInstRef" v-model:value="activeKey"
        :options="menuOptions" @update-value="changMenu" :default-expanded-keys="defaultExpandedKeys" />
</template>


<script lang="ts">
import { defineComponent, h, ref, Component, reactive, watch, onMounted } from 'vue';
import { NIcon, NLayoutSider, NMenu, NImage } from 'naive-ui'

import { MenuInst } from 'naive-ui';
import { useStore } from "vuex";
import renderIconComponents from '@/plugins/menuRenderIcon';

function renderIcon(Icon: Component) {
    return () => h(NIcon, null, { default: () => h(Icon) })
}
let menuOptions = ref([])
export default defineComponent({
    props: ['activeKey'],
    components: { NLayoutSider, NMenu, NImage },
    setup(props) {
        const store = useStore()
        let activeKey = ref(props.activeKey)
        const menuInstRef = ref<MenuInst | null>(null)
        const defaultExpandedKeys = ref([activeKey.value]);

        watch(() => store.getters['menuStore/getActiveKey'], (n) => {
            activeKey.value = n;
            menuInstRef.value?.showOption(n)
        })
        setTimeout(() => {
            menuInstRef.value?.showOption(activeKey.value)
        }, 500);

        watch(() => store.getters['auth/getGroupMenus'], (n) => {
            const _arr: any = JSON.parse(JSON.stringify(n));
            _arr.forEach((element: any) => {
                const _icon = renderIconComponents(element.icon);
                element.icon = renderIcon(_icon);
            });
            menuOptions.value = _arr;
        }, { deep: true })

        return {
            activeKey,
            menuOptions,
            menuInstRef,
            defaultExpandedKeys,
        }
    },

    created() {
        this.init()
    },
    methods: {
        async init() {
            const { data } = await this.$store.dispatch('auth/authentication');
            if (data) {
                const _path = this.$route.path.replace('/admin/', '');
                if (!data.groupMenuKey[_path]) {
                    return this.$router.replace({
                        path: '/admin/404'
                    })
                }

                const tab = {
                    path: '/admin/' + _path,
                    title: data.groupMenuKey[_path][1],
                    pin: true,
                    pathKey: data.groupMenuKey[_path][0],
                }

                this.$store.dispatch("adminNavStore/addTab", tab);

                // data.groupMenus.forEach((element: any) => {
                //     const _icon = renderIconComponents(element.icon);
                //     element.icon = renderIcon(_icon);
                //     this.menuOptions.push(element);
                // });
            }
        },
        changMenu(e: string, item: any) {
            let home = '/admin/'
            this.$store.dispatch("menuStore/setActiveKey", e);
            const tab = {
                path: home + e,
                title: item.label,
                pin: true,
                pathKey: item.pathKey,
            }
            this.$store.dispatch("adminNavStore/addTab", tab)
            return this.$router.push(home + e);
        },
    }
})
</script>

<style lang="scss" scoped>

</style>
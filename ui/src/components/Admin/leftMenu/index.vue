<template>
    <n-layout-sider class="left-menu" :class="
        (collapsed == true ? ' collapsed ' : '') +
        (theme == null ? '  moon ' : 'drak')
    " bordered collapse-mode="width" :collapsed-width="90" :width="268" :collapsed="collapsed" show-trigger
        @collapse="collapsed = true" @expand="collapsed = false">
        <div class="user-box">
            <div class="account-box">
                <Avatar :showLabel="true" v-model:src="userInfo.avatar" />
                <div class="info">
                    <div class="name">{{ userInfo.username }}</div>
                    <div class="des">{{ userInfo.adminGroupId }}</div>
                </div>
            </div>
            <div style="margin-top:35px;" v-if="collapsed != true">
                <n-dropdown :options="[
                    {
                        label: '退出登录',
                        key: 'logout',
                    },
                ]" placement="bottom-start" trigger="click" @select="handleSelect">

                    <n-button strong secondary circle>
                        <template #icon>
                            <Icon>
                                <LogOutOutline />
                            </Icon>
                        </template>
                    </n-button>
                </n-dropdown>
            </div>
        </div>
        <GeneralMenu :activeKey="activeKey" />
        <div class="left-filter-box">
        </div>
    </n-layout-sider>
</template>


<script lang="ts">
import { defineComponent, computed, ref, watch } from 'vue'
import GeneralMenu from "./general.vue"
import { useStore } from "vuex";
import Avatar from "@/components/common/Avatar.vue";
import { LogOutOutline } from '@vicons/ionicons5';
import { Icon } from '@vicons/utils';

export default defineComponent({
    components: { GeneralMenu, Avatar, LogOutOutline, Icon },
    setup() {
        const store = useStore()
        const activeKey = computed(() => {
            return store.getters['menuStore/getActiveKey'];
        });

        const theme = computed(() => {
            return store.getters['theme/getTheme'];
        })

        const userInfo = computed(() => {
            return store.getters['auth/getUser'];
        })
        // const userInfo = 
        return {
            userInfo,
            activeKey,
            theme,
            collapsed: ref(false)
        }
    },

    created() {
        let path = this.$route.path.replace('/admin/', '');
        this.$store.dispatch("menuStore/setActiveKey", path);
    },
    methods: {
        async handleSelect(e: any) {
            if (e == 'logout') {
                // 
                const { data } = await this.$http.post('admin/api/auth/logout');
                if (data) {
                    this.$store.dispatch('auth/logout');
                    this.$store.dispatch('auth/initClientId');
                    return this.$router.push({
                        path: '/admin/login',
                        query: { direct: this.$route.fullPath },
                    });
                }
            }
        }
    }
})
</script>

<style lang="scss" scoped>
.moon {
    background: #f8f8f8;
}

.drak {
    background: #272735;
}

.left-menu {
    transition: all 0.1s;
    height: 100vh;

    :deep(.n-menu-item) {
        height: 50px;
        margin-top: 0;
        padding: 0 16px;
    }
    :deep(.n-menu-item-content) {
        height: 50px;
        padding-left: 25px !important;
        font-weight: 700;
        color: #000;
        font-family: "Arial", "Microsoft YaHei", sans-serif;
    }
    :deep(.n-menu-item-content__icon) {
        margin-right: 15px !important;
    }
   
    :deep(.n-submenu-children) {
        .n-menu-item-content {
            padding-left: 62px !important;
        }
    }

    .user-box {
        margin-left: 40px;
        margin-right: 45px;
        margin-top: 75px;
        margin-bottom: 45px;
    }

    .account-box {
        display: flex;

        .info {
            margin-left: 18px;
            z-index: 1;

            .name {
                font-weight: 700;
                margin-top: 8px;
                font-size: 18px;
            }

            .des {
                font-size: 11px;
            }
        }
    }
}

.collapsed {
    .user-box {
        margin: 0;
        margin-top: 75px;
        margin-left: 18px;
        margin-bottom: 45px;

        .avatar {
            width: 45px;
            min-width: 45px;
            height: 45px;
            box-shadow: none;
            border-radius: 100%;

            :deep(img) {
                border-radius: 100%;
            }
        }

        .info {
            display: none;
        }
    }

    :deep(.n-menu-item-content) {
        padding-left: 18px !important;
    }



    :deep(.n-menu-item-content--selected .n-menu-item-content__icon::before) {
        width: 60px !important;
        border-radius: 6px;
        left: 7px;
    }

    :deep(.n-menu-item-content::before) {
        min-width: 50px;
        left: 4px;
    }
}
</style>
<!-- content.vue -->
<template>
  <n-card class="header-tabs" content-style="padding: 0;">
    <n-tabs type="card" :tabs-padding="20" class="tabs" closable @close="handleClose" v-model:value="defaultTab"
      @update:value="handleUpdateValue">
      <template v-for="item in navTabs" :key="item.path">
        <n-tab class="item" :name="item.title" :closable="item.pin">
        </n-tab>
      </template>
    </n-tabs>
  </n-card>
</template>

<script lang="ts">
import { computed, defineComponent, ref, reactive, watch } from 'vue'
import { useStore } from 'vuex'
export default defineComponent({
  setup() {
    const store = useStore()

    const navTabs = computed(() => {
      return store.getters['adminNavStore/getTabs'];
    });

    const defaultTab = ref('')

    watch(() => store.getters['adminNavStore/getCurrentTab'], (n) => {
      defaultTab.value = n.title
    }, { deep: true })

    return {
      navTabs,
      defaultTab,
      handleClose(e: any) {
        store.dispatch("adminNavStore/deleteTab", e);
      },
    }
  },
  methods: {
    handleUpdateValue(e: any) {
      this.navTabs.forEach((element: { title: any; path: any; }) => {
        if (element.title == e) {
          this.$store.dispatch("adminNavStore/addTab", element);
          this.$router.push(element.path);
        }
      });
    }
  }
})
</script>
<style lang="scss" scoped>
.header-tabs {
  border-radius: none !important;
  border: none !important;

  .tabs {
    overflow-x: auto;
  }

  :deep(.n-tabs-wrapper) {
    padding: 3px 0;
  }

  :deep(.n-tabs-nav) {
    background: var(--n-color-segment);
  }

  :deep(.n-tabs-tab) {
    border: none !important;
    top: -1px;
  }

  :deep(.n-tabs-tab--active) {
    background: var(--n-color-popover) !important;
    border-radius: 6px !important;
    box-shadow: 0 1px 3px 0 rgb(0 0 0 / 8%);
  }

  .item {
    display: none !important;
  }
}
</style>
export default {
  install: (app: any , store: any) => {
    app.config.globalProperties.$can = (actionId: any) => {
      return store.getters['auth/isRouteInAcl'](actionId)
    }
  }
}
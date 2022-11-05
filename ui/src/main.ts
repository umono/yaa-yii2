import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import { store } from './store'
import HttpRequest from '@/utils/http/http'
import commonMixin from "@/mixins/common"
import AclChecker from './plugins/AclChecker'


const app = createApp(App);



app.config.globalProperties.$http = HttpRequest;
app.config.globalProperties.$store = store;



app.mixin(commonMixin);

app.use(store)
    .use(AclChecker, store)
    .use(router)
    .mount('#app')


import { createApp } from 'vue'
import App from './App.vue'
import VueSweetalert2 from 'vue-sweetalert2'
import router from './router'

const app = createApp(App)

app.use(router);

app.use(VueSweetalert2);

app.mount('#app')

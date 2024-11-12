import { createApp, h } from 'vue'
import { createStore } from 'vuex'
import './styles.scss'
import Store from './store';
import router from "./router";
import App from "./App.vue";
import './config/axios';

const store = createStore(Store);

const app = createApp(App);
app.use(router);
app.use(store);
app.mount('#app');

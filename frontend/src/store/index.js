import auth from './modules/auth';
import client from './modules/client';
import createPersistedState from "vuex-persistedstate";

export default {
    modules: {
        auth,
        client,
    },
    plugins: [createPersistedState()]
}

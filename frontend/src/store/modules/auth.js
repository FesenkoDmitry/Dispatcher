import axios from "axios";

export default {
    state: {
        user: null,
    },
    getters: {
        user: state => state.user,
    },
    mutations: {
        setUser(state, user) {
            state.user = user;
        },
        clearUser(state) {
           state.user = null;
        },
    },
    actions: {
        login({commit}, user) {
            axios.post('login', user)
                .then(response => commit('setUser', response.data))
                .then(error => console.log(error))
        },
        logout({commit}) {
            commit('clearUser');
        }
    },
}
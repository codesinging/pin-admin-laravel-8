import {defineStore} from "pinia";

export default defineStore('state', {
    state: () => ({
        states: {
            loading: false,
        },
    }),

    getters: {
        get: (state) => {
            return (...keys) => !!state.states[keys.join('_')]
        }
    },

    actions: {
        set(...keys) {
            this.states[keys.join('_')] = true
        },

        unset(...keys) {
            this.states[keys.join('_')] = false
        }
    },
})


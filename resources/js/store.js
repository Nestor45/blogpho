export default {
    state: {
        welcomeMessage: 'Welcome to my vue app'
    },
    mutations: {
        welcome(state){
            return state.welcomeMessage;
        }
    },
    getters: {},
    actions: {}
}
import { getLocalUser } from "./helpers/auth";

const user = getLocalUser();

export default {
    state: {
        currentUser: user,
        isLoggerIn: !!user,
        loading: false,
        auth_error: null,
        customers: [],
        customer: [],
        bandLogin: false,
        questions: [],
        questionsRes: [],
    },
    getters: {
        isLoading(state){
            return state.loading
        },
        isLoggerIn(state){
            return state.isLoggerIn
        },
        currentUser(state){
            return state.currentUser
        },
        auth_error(state){
            return state.auth_error
        },
        getCustomers(state){
            return state.customers
        },
        getCustomer(state){
            return state.customer
        },
        bandLogin(state){
            return state.bandLogin
        },
        getQuestions(state){
            return state.questions
        },
        getQuestionsRes(state){
            return state.questionsRes
        }
    },
    mutations: {
        login(state){
            state.loading = true
            state.auth_error = null
        },
        loginSuccess(state, payload){
            state.auth_error = null
            state.isLoading = true
            state.loading = false
            state.currentUser = Object.assign({}, payload.user, {token: payload.access_token})

            localStorage.setItem("user", JSON.stringify(state.currentUser))
        },
        loginFailed(state, payload){
            state.loading = false
            state.auth_error = payload.error
        },
        logout(state){
            localStorage.removeItem("user")
            state.isLoggerIn = false
            state.currentUser = null
        },
        setCustomers(state, payload){
            state.customers = payload
        },
        setCustomer(state, payload){
            state.customer = payload
        },
        setBandLogin(state, payload){
            state.bandLogin = payload
        },
        setQuestions(state, payload){
            state.questions = payload
        },
        setQuestionsRes(state, payload){
            state.questionsRes = payload
        }
    },
    actions: {
        login(context){
            context.commit("login")
        }
    }
}
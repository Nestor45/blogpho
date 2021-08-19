<template>
    <div>
        <v-app-bar p-bar color="#444857">
            <v-app-bar-nav-icon @click="drawer = true"></v-app-bar-nav-icon>
        </v-app-bar>
        <v-navigation-drawer v-model="drawer" absolute temporary>
            <v-list nav danse>
                <v-list-item-group v-model="group" active-class="deep-purple--text text--accent-4">
                    <template v-if="this.$store.state.currentUser">
                        <v-list-item @click="home">
                            <v-list-item-icon>
                                <v-icon>mdi-home</v-icon>
                            </v-list-item-icon>
                            <v-list-item-title >Home</v-list-item-title>
                        </v-list-item>
                        <v-list-item @click="customer">
                            <v-list-item-icon>
                                <v-icon>mdi-account-multiple</v-icon>
                            </v-list-item-icon>
                            <v-list-item-title >Customer</v-list-item-title>
                        </v-list-item>
                        <v-list-item @click="logout">
                            <v-list-item-icon>
                                <v-icon>mdi-account-convert</v-icon>
                            </v-list-item-icon>
                            <v-list-item-title >Log Out</v-list-item-title>
                        </v-list-item>
                        
                    </template>
                    <template v-else>
                        <template v-if="bandPre">
                            <v-list-item @click="login">
                                <v-list-item-icon>
                                    <v-icon>mdi-account</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title >Login</v-list-item-title>
                            </v-list-item>
                        </template>
                        <template v-else>
                            <v-list-item @click="home">
                                <v-list-item-icon>
                                    <v-icon>mdi-home</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title >Home</v-list-item-title>
                            </v-list-item>
                            
                        </template>
                    </template>
                </v-list-item-group>
            </v-list>
        </v-navigation-drawer>
    </div>
    
</template>
<script>
export default {
    name: 'app-header',
    data() {
        return {
            drawer: false,
            group: null,
            band: false,
            bandPre: false,
        }
    },
    created() {
        if (this.$store.state.currentUser){
            console.log("dentor de created")
        }
        this.infoUser()
    },
    computed: {
        currentUser() {
            return this.$store.getters.currentUser
        }
    },
    methods: {
        infoUser(){
            console.log("band", this.band)
            console.log("bandPre", this.bandPre)
            if( !this.band ) {
                this.band = true
            }
        },
        customer() {
            console.log("click customer")
            this.$router.push('/customers')
        },
        login() {
            this.bandPre = false
            console.log("click login", this.bandPre)
            this.$router.push('/login')
        },
        logout() {
            this.band = false
            console.log("click logout", this.band)
            this.$store.commit('logout')
            this.$router.push('/login')
        },
        home() {
            if (this.$store.getters.currentUser) {
                this.bandPre = false
            }else{
                this.bandPre = true
            }
            console.log("click home", this.bandPre)
            this.$router.push('/')
            
        }
    },
    computed: {

    }
}
</script>
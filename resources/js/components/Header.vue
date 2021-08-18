<template>
    <div>
        <v-app-bar p-bar color="#444857">
            <v-app-bar-nav-icon @click="drawer = true"></v-app-bar-nav-icon>
        </v-app-bar>
        <v-navigation-drawer v-model="drawer" absolute temporary>
            <v-list nav danse>
                <v-list-item-group v-model="group" active-class="deep-purple--text text--accent-4">
                    <v-list-item>
                        <v-list-item-icon>
                            <v-icon>mdi-home</v-icon>
                        </v-list-item-icon>
                        <v-list-item-title @click="home">Home</v-list-item-title>
                    </v-list-item>
                    <v-list-item>
                        <v-list-item-icon>
                            <v-icon>mdi-account</v-icon>
                        </v-list-item-icon>
                        <v-list-item-title @click="login">Login</v-list-item-title>
                    </v-list-item>
                    <v-list-item>
                        <v-list-item-icon>
                            <v-icon>mdi-account-convert</v-icon>
                        </v-list-item-icon>
                        <v-list-item-title @click="logout" >Log Out</v-list-item-title>
                    </v-list-item>
                </v-list-item-group>
            </v-list>
        </v-navigation-drawer>
    </div>
</template>
<script>
//import Auth from '../../helpers/auth'

export default {
    name: 'app-header',
    data() {
        return {
            drawer: false,
            group: null,
        }
        
    },
    methods: {
        home() {
            this.$router.push('/customers')
        },
        login() {
            this.$router.push('/login')
        },
         logout() {
            this.$store.commit('logout');
            this.$router.push('/login');
        }
    },
    computed: {

    }
}
</script>
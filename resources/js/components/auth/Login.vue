<template>
    <v-card
        class="mx-auto my-12"
        max-width="574"
    >
        <v-card-text>
            <v-form ref="form" v-model="valid">
                <v-text-field
                    prepend-icon="mdi-email"
                    name="email"
                    label="Email"
                    type="emial"
                    :rules="emailRules"
                    v-model="form.email"
                ></v-text-field>
                <v-text-field
                    id="password"
                    prepend-icon="mdi-key"
                    name="password"
                    label="Password"
                    type="password"
                    :rules="passwordRules"
                    v-model="form.password"
                ></v-text-field>
                <v-spacer></v-spacer>
                <v-btn
                    :disabled="!valid"
                    text
                    color="teal accent-4"
                    @click="authenticate"
                >
                    Login
                </v-btn>
                <v-btn
                    :disabled="valid"
                    text
                    color="teal accent-4"
                    @click="register"
                >
                    Register
                </v-btn>
            </v-form>
        </v-card-text>
    </v-card>
</template>
<script>
    import {login} from '../../helpers/auth';
    export default {
        name : 'loginView',
        data() {
            return {
                valid: true,
                form : {
                    email: '',
                    password: '',
                    band: false,
                },
                emailRules: [
                    v => !!v || 'E-mail is required',
                    v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
                ],
                passwordRules: [
                    v => !!v || 'Password is required',
                ],
                error: null
            }
        },
        
        methods : {
            authenticate() {
                this.$store.dispatch('login')
                login(this.form)
                    .then((res)=>{
                        
                        this.$store.commit("loginSuccess",res)
                        this.$router.push({path: '/validar'})
                        event.preventDefault()
                    })
                    .catch((error)=>{
                        this.$store.commit("loginFailed",{error})
                    })
            },
            register() {
                this.$router.push({path: '/register'})
            }
        }
    }
</script>
<style>
    #login {
        background-color: aqua;
    }
</style>
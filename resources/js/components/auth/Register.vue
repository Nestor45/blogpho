<template>
    <div class="container">
        <div class="row justify-content-center" style="margin:15px">
            <v-card lass="mx-auto my-12" max-width="500">
                <v-card-text>
                    <v-list-item two-line>
                        <v-list-item-content>
                            <v-list-item-title class="text-h5">
                                REGISTRAR NUEVO USUARIO
                            </v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-form ref="form" v-model="valid">
                        <v-text-field
                            v-model="register.name"
                            :rules="nameRules"
                            label= "Name"
                            required
                            prepend-icon="mdi-account-settings"
                        ></v-text-field>
                        <v-text-field
                            v-model="register.lastname"
                            :rules="lastnameRules"
                            label= "Last Name"
                            required
                            prepend-icon="mdi-account-settings"
                        ></v-text-field>
                        <v-text-field
                            v-model="register.username"
                            :rules="usernameRules"
                            label= "User Name"
                            required
                            prepend-icon="mdi-account-settings"
                        ></v-text-field>
                        <v-text-field
                            v-model="register.email"
                            :rules="emailRules"
                            label= "Email"
                            type="email"
                            required
                            prepend-icon="mdi-email"
                        ></v-text-field>
                        <v-text-field
                            v-model="register.password"
                            :rules="passwordRules"
                            label= "Password"
                            type="password"
                            required
                            prepend-icon="mdi-key"
                        ></v-text-field>
                        <v-text-field
                            v-model="register.confirm_password"
                            :rules="confirm_passwordRules"
                            label= "Confirm Password"
                            type="password"
                            required
                            prepend-icon="mdi-key"
                        ></v-text-field>
                        <v-btn
                            :disabled="!valid"
                            text
                            color="teal accent-4"
                            @click="registerbtn"
                        >
                            Register
                        </v-btn>
                    </v-form>
                </v-card-text>
            </v-card>
        </div>
    </div>
</template>
<script>
    export default {
        name: 'register-user',
        data() {
            return{
                valid: true,
                register: {
                    name: '',
                    lastname: '',
                    username: '',
                    email: '',
                    password: '',
                    confirm_password: ''
                },
                nameRules: [
                    v => !!v || 'Es necesario llenar le dato Name',
                ],
                lastnameRules: [
                    v => !!v || 'Es necesario llenar le dato Last Name',
                ],
                usernameRules: [
                    v => !!v || 'Es necesario llenar le dato User Name',
                ],
                emailRules: [
                    v => !!v || 'E-mail is required',
                    v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
                ],
                passwordRules: [
                    v => !!v || 'Es necesario llenar le dato Password',
                ],
                confirm_passwordRules: [
                    v => (!!v && v) === this.register.password || 'Passwords no coinciden',
                ],
            }
        },
        methods:{
            async registerbtn() {
                console.log(this.register)
                try {
                    let response = await axios.post('/api/registerUser', this.register)
                    if (response.status===200) {
                        this.$router.push({path: '/login'})
                    } else {
                        console.log("algo salio mal al registrar")
                    }
                } catch (error) {
                    console.log(error)
                }
            }
        }
    }
</script>

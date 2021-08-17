<template>
    <div class="container">
        <div class="row justify-content-center">
            <v-card
                lass="mx-auto my-12"
                max-width="400"
            >
                <v-card-text>
                    <v-list-item two-line>
                        <v-list-item-content>
                            <v-list-item-title class="text-h5">
                                AGREGAR NUEVO CLIENTE
                            </v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-form
                        ref="form"
                        v-model="valid"
                        
                    >
                        <v-text-field
                            v-model="form.name"
                            :rules="nameRules"
                            label="Name"
                            required
                        ></v-text-field>
                        <v-text-field
                            v-model="form.phone"
                            :counter="10"
                            :rules="nameRules"
                            label="Phone"
                            required
                        ></v-text-field>
                        <v-text-field
                            v-model="form.email"
                            :rules="emailRules"
                            label="E-mail"
                            type="emial"
                            required
                        ></v-text-field>
                        <v-text-field
                            v-model="form.website"
                            :rules="websiteRules"
                            label="Web Site"
                            required
                        ></v-text-field>
                        <v-spacer></v-spacer>
                        <v-btn
                            :disabled="!valid"
                            text
                            color="teal accent-4"
                            @click="saveCustomer"
                        >
                            Guardar Datos
                        </v-btn>
                    </v-form>
                </v-card-text>
                
            </v-card>
        </div>
    </div>
    
    
</template>
<script>
export default {
    name: 'new',
    data() {
        return {
            valid: true,
            form : {
                name: '',
                phone: '',
                email: '',
                website: '',
            },
            nameRules: [
                v => !!v || 'Name is required',
            ],
            phoneRules: [
                v => !!v || 'Phone is required',
            ],
            emailRules: [
                v => !!v || 'Email is required',
                v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
            ],
            websiteRules: [
                v => !!v || 'Website is required',
            ]
        }
    },
    methods : {
        async saveCustomer() {
            console.log(this.form)
            try {
                let response = await axios.post('/api/customers/new', this.form)
                if (response.status === 200) {
                    this.$router.push('/customers')
                } else {
                    alert("algo esta mal al registrar")
                }
            } catch (error) {
                console.log(error)
            }
        }
    }
}
</script>
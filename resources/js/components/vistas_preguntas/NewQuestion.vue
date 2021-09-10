<template>
    <div>
        <div class="container">
            <div class="row justify-content-center">
                <v-card style="margin-top: 16px" max-width="800">
                    <v-card-text>
                        <v-form>
                            <v-col cols="12">
                                <v-alert
                                    color="#92C145"
                                    icon="mdi-emoticon"
                                    dense
                                    text
                                    type="success"
                                >
                                    Las preguntas serán <strong>validadas</strong> y <strong>aceptadas</strong> por el administrador
                                </v-alert>
                                <!-- <v-list-item two-line>
                                    <v-list-item-content> -->
                                        <v-list-item-title class="text-h5 justify-content-center">
                                            AGREGAR PREGUNTA
                                        </v-list-item-title>
                                    <!-- </v-list-item-content>
                                </v-list-item> -->
                            
                                <v-text-field
                                    v-model="DatoPregunta.pregunta"
                                    :rules="preguntaRules"
                                    label="Ingrese su pregunta"
                                ></v-text-field>
                                <v-btn
                                    text
                                    color="#92C145"
                                    @click="preguntar()"
                                >
                                    Subir Pregunta
                                </v-btn>
                            </v-col>
                            
                        </v-form>
                    </v-card-text>
                </v-card>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: 'preguntas-view',
    data(){
        return{
            DatoPregunta: {
                pregunta: '',
                id_user: '',
            },
            preguntaRules: [
                v => !!v || 'La pregunta es requerida',
            ],
        }
    },
    created(){
        this.infoUser()
    },
    methods: {
        infoUser(){
            let $user = this.$store.getters.currentUser
            this.DatoPregunta.id_user = $user.id 
        },
        async preguntar() {
            try {
                let response = await axios.post('/api/post/create', this.DatoPregunta)
                if (response.status === 200) {
                    this.$router.push('/validar')
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
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

                                <v-list-item-title class="text-h5 justify-content-center">
                                            AGREGAR PREGUNTA
                                </v-list-item-title>

                                <v-text-field
                                    v-model="datoPregunta.pregunta"
                                    :rules="preguntaRules"
                                    label="Ingresé su pregunta"
                                ></v-text-field>

                                <v-select
                                    v-model="datoPregunta.type_seccion"
                                    :items="items"
                                    attach
                                    chips
                                    label="Sección **POR IMPLEMENTAR"
                                    multiple
                                ></v-select>

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
            items: ['salud', 'educación', 'política', 'ambiental', 'tecnología', 'familiar', 'social', 'laboral'],
            datoPregunta: {
                type_seccion: '',
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
            this.datoPregunta.id_user = $user.id 
        },
        async preguntar() {
            try {
                console.log(
                    "datosPregu",this.datoPregunta
                )
                let response = await axios.post('/api/post/create', this.datoPregunta)
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
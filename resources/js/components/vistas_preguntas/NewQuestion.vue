<template>
    <div>
        <div class="container">
            <div class="row justify-content-center">
                <v-card style="margin-top: 16px" max-width="800">
                    <v-card-text>
                        <v-list-item two-line>
                            <v-list-item-content>
                                <v-list-item-title class="text-h5">
                                    AGREGAR PREGUNTA
                                </v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                        <v-form>
                            <v-text-field
                                v-model="DatoPregunta.pregunta"
                                :rules="preguntaRules"
                                prepend-icon="mdi-new-box"
                                label="Ingrese su pregunta"
                            ></v-text-field>
                            <v-btn
                                text
                                color="teal accent-4"
                                @click="preguntar()"
                            >
                                Subir Pregunta
                            </v-btn>
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
                v => !!v || 'Name is required',
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
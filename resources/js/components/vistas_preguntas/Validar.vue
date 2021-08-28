<template>
    <div class="container">
        <template v-if="there_is_questions">
            <v-timeline dense>
                <v-slide-x-reverse-transition
                    group
                    hide-on-leave
                >
                    <v-timeline-item
                    v-for="(item, i) in questions"
                    :key="i"
                    fill-dot
                    icon="mdi-account"
                    >
                            <v-card shaped :style="styleObject2" >
                                <span class="color_span"></span>{{item.title}} <br>
                                <span class="color_span">AUTOR: </span>{{item.user_name}}
                            </v-card>
                            <v-card-actions>
                                <v-btn
                                    color="#6cb2eb"
                                    class="mx-4"
                                    outlined
                                    @click="dialog = !dialog, questionResp.id_question= item.id_question"
                                >
                                    Responder
                                </v-btn>
                                <v-btn
                                    color="#6cb2eb"
                                    class="mx-4"
                                    outlined
                                    @click="eliminarQuestion(item)"
                                >
                                    Eliminar
                                </v-btn>
                            </v-card-actions>
                            <v-dialog
                                v-model="dialog"
                                max-width="500px"
                            >
                                <v-card>
                                    <v-col cols="12">
                                        <v-card-text>
                                            <v-textarea
                                                auto-grow
                                                label="Escribir respuesta en este campo*"
                                                v-model="questionResp.response_ques"
                                            ></v-textarea>
                                            <small class="grey--text">* La respuesta sera publicada y vista por usuarios no registrados.</small>
                                        </v-card-text>
                                    </v-col>
                                    <v-card-actions>
                                        <v-spacer></v-spacer>
                                        <v-btn
                                        text
                                        color="primary"
                                        @click="responderQuestion()"
                                        >
                                        Responder
                                        </v-btn>
                                    </v-card-actions>
                                </v-card>
                            </v-dialog>
                    </v-timeline-item>
                </v-slide-x-reverse-transition>
            </v-timeline>
        </template>
        <template v-else>
            <v-card
                class="mx-auto"
                max-width="444"
            >
                <v-card-text>
                    <p class="text-h4 text--primary">
                        No hay publicaciones 
                    </p>
                </v-card-text>
            </v-card>
        </template>
    </div>
</template>
<script>
export default {
    name: 'validar',
    data() {
        const COLORS = [
            'info',
            'warning',
            'error',
            'success',
        ]
        const ICONS = {
            info: 'mdi-information',
            warning: 'mdi-alert',
            error: 'mdi-alert-circle',
            success: 'mdi-check-circle',
        }
        return {
            dialog: false,
            isLoading: true,
            there_is_questions: false,
            questions: [],
            questionResp: {
                response_ques: '',
                id_question: '',
                id_user: '',
            },
            styleObject2: {
                border: '3px solid #AED6F1'
            }
        }
    },
    created(){
        this.questionsAll()
        this.infoUser()
    },
    methods: {
        infoUser(){
            let $user = this.$store.getters.currentUser
            this.questionResp.id_user = $user.id 
        },
        async questionsAll(){
            try {
                let response = await axios.get('/api/questions')
                this.questions = response.data.questions
                if (response.data.error === "No hay nada en la BD") {
                    this.there_is_questions = false
                } else {
                    this.there_is_questions = true
                    this.$store.commit('setQuestions', response.data.questions)
                }
            } catch (error) {
                console.log(error)
            }
        },
        async eliminarQuestion(item){
            try {
                let response = await axios.post('/api/post/delete',item)
                if (response.status === 200) {
                    console.log("dentor del if de eliminarQues")
                    this.questionsAll()
                } else {
                    console.log("algo salio mal al eliminar")
                }
            } catch (error) {
                console.log(error)
            }
        },
        async responderQuestion(){
            console.log("dentro de responder",this.questionResp)
            try {
                let response = await axios.post('/api/post/respuesta',this.questionResp)
                if (response.status === 200) {
                    // this.questionsAll()
                    this.dialog = false
                    this.$router.push('/')
                } else {
                    console.log("algo salio mal al responder la pregunta")
                }
            } catch (error) {
                console.log(error)
            }
        }
    }
}
</script>
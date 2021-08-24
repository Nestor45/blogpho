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
                                >
                                    Publicar
                                </v-btn>
                                <v-btn
                                    color="#6cb2eb"
                                    class="mx-4"
                                    outlined
                                >
                                    Eliminar
                                </v-btn>
                            </v-card-actions>
                    </v-timeline-item>
                </v-slide-x-reverse-transition>
            </v-timeline>
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
            isLoading: true,
            there_is_questions: false,
            questions: [],
            styleObject2: {
                border: '3px solid #AED6F1'
            }
        }
    },
    created(){
        this.questionsAll()
    },
    methods: {
        async questionsAll(){
            try {
                let response = await axios.get('/api/questions')
                this.questions = response.data.questions
                if (this.questions.length === 0) {
                    console.log("no hay preguntas")
                } else {
                    this.there_is_questions = true
                    this.$store.commit('setQuestions', response.data.questions)
                    console.log(response.data.questions)
                }
            } catch (error) {
                console.log(error)
            }
        }
    }
}
</script>
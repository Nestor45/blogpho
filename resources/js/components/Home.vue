<template>
    <div class="container">
        <!-- <v-data-iterator
            :search="search"
            hide-default-footer
        > 
            <template v-slot:header> -->
                <v-toolbar
                    dark
                    color="grey darken-1"
                    class="mb-1"
                >
                    <v-text-field
                    v-model="search"
                    clearable
                    flat
                    solo-inverted
                    hide-details
                    prepend-inner-icon="mdi-magnify"
                    label="Buscar Pregunta"
                    ></v-text-field>
                    <template v-if="$vuetify.breakpoint.mdAndUp">
                        <v-spacer></v-spacer>
                        <v-select
                            v-model="sortBy"
                            flat
                            solo-inverted
                            hide-details
                            :items="keys"
                            prepend-inner-icon="mdi-find-replace"
                            label="Filtrar por"
                        ></v-select>
                        <v-spacer></v-spacer>
                        <v-btn-toggle v-model="sortDesc" mandatory>
                            <v-btn large depressed color="grey darken-1" :value="false">
                                <v-icon>mdi-arrow-up</v-icon>
                            </v-btn>
                            <v-btn large depressed color="grey darken-1" :value="true">
                                <v-icon>mdi-arrow-down</v-icon>
                            </v-btn>
                        </v-btn-toggle>
                    </template>
                </v-toolbar>
            <!-- </template> -->

            <template v-if="there_is_questions">
                <template v-if="errorHome">
                    <v-alert
                        text
                        dense
                        color="teal"
                        icon="mdi-clock-fast"
                        border="left"
                        >
                        PARA REALIZAR UNA PREGUNSTA Y UNA MEJOR EXPIENZA PUEDE REGISTRARSE.(falata filtrar peguntas por areas (salud, educación, politica, ambiental, tecnología, familiar, social, laboral)
                    </v-alert>
                </template>
                <v-col v-for="(item, i) in questions" :key="i">
                        <v-card
                            class="mx-auto"
                            elevation="24"
                            rounded='xl'
                            color="grey darken-1"
                            dark
                            max-width="800"
                        >
                            <v-card-title>
                                <v-icon
                                    large
                                    left
                                >
                                    mdi-account-tie-voice
                                </v-icon>
                                <span class="title font-weight-light">{{item.title}}</span>
                            </v-card-title>
                            <v-card-text class="headline font-weight-bold" >
                                {{item.context}}
                            </v-card-text>
                            <v-card-actions>
                                <v-list-item class="grow">
                                    <v-list-item-avatar color="grey darken-3">
                                        <v-img
                                        class="elevation-6"
                                        src="https://avataaars.io/?avatarStyle=Transparent&topType=ShortHairShortCurly&accessoriesType=Prescription02&hairColor=Black&facialHairType=Blank&clotheType=Hoodie&clotheColor=White&eyeType=Default&eyebrowType=DefaultNatural&mouthType=Default&skinColor=Light"
                                        ></v-img>
                                    </v-list-item-avatar>
                                    <v-list-item-content>
                                        <v-list-item-title>{{item.user_name}}</v-list-item-title>
                                    </v-list-item-content>
                                    <v-row
                                        align="center"
                                        justify="end"
                                    > 
                                        <v-btn
                                            @click="like(item)"
                                            fab
                                            icon
                                        >
                                            <v-icon >{{item.type_like}}</v-icon>
                                        </v-btn>
                                        <span class="subheading mr-2">{{item.likes}}</span>
                                    </v-row>
                                </v-list-item>
                            </v-card-actions>
                        </v-card>
                </v-col>
            </template>
            <template v-else>
                <v-card
                    class="mx-auto"
                    max-width="444"
                >
                    <v-card-text>
                        <p class="text-h4 text--primary">
                            <v-alert
                                icon="mdi-sleep"
                                prominent
                                text
                                type="info"
                            >
                                No hay publicaciones
                            </v-alert>
                        </p>
                    </v-card-text>
                </v-card>
            </template>
        <!-- </v-data-iterator> -->
    </div>
</template>
<script>
export default {
    name: 'home',
    data() {
        return {
            sortDesc: false,
            sortBy: '',
            search: '',
            errorHome: false,
            there_is_questions: false,
            likeEn: {
                user_log_id: '',
                post_id: 0,
                type_like : '',
            },
            questions: [],
            keys: [ 
                'Salud', 
                'Educación', 
                'Politica', 
                'Ambiental', 
                'Tecnología', 
                'Familiar', 
                'Social', 
                'Laboral'
            ],
        }
    },
    created(){
        this.questionsContestadas()
    },
    methods: {
        async questionsContestadas(){
            try {
                //Obtenemos las preguntas con sus respuestas
                let response = await axios.get('/api/questions/respuesta')
                //Ahora this.questions tiene las preguntas y sus respuestas
                this.questions = response.data.questionsRes
                if (this.questions.length === 0) {
                    this.there_is_questions = false
                    console.log("no hay preguntas")
                } else {
                    if (this.$store.getters.currentUser===null) {
                        this.errorHome = true
                    }
                    this.there_is_questions = true
                    this.$store.commit('setQuestionsRes', this.questions)
                }
            } catch (error) {
                
                console.log("questionsContestadas",error)
            }
        },
        async like(item){
            try {
                    //Todo: en este caso tememos por defaul a show2 en true
                    let user = this.$store.getters.currentUser
                    this.likeEn.user_log_id = user.id
                    this.likeEn.post_id = item.post_id
                    this.likeEn.type_like = 'mdi-heart'
                    let response = await axios.post('/api/post/like',this.likeEn)
                    //Enviamos las solicitud y no debuelve un 200 ó 250
                    if (response.status===250) {
                        this.likeEn.type_like = 'mdi-heart-outline'
                        //Si el status es 250 quiere decir que exite un registro(un like)
                        response = await axios.post('/api/post/dislike',this.likeEn)
                        //Todo: Entonces debemos hacer un dislike
                        if (response.status === 200) {
                            this.questionsContestadas()
                        } else {
                            console.log("Error")
                        }
                    } else if (response.status===200) {
                        //Todo: en caso de que status se 200 no habia registro
                        this.questionsContestadas()
                    }
                
            } catch (error) {
                console.log(error)
                this.$router.push({path: '/register'})
            }
        },
    }
}
</script>
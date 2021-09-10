<template>
    <div class="container">
        <template v-if="there_is_questions">
            <template v-if="errorHome">
                <v-alert
                    text
                    dense
                    color="teal"
                    icon="mdi-clock-fast"
                    border="left"
                    >
                    PARA REALIZAR UNA PREGUNSTA Y UNA MEJOR EXPIENZA PUEDE REGISTRARSE.   
                </v-alert>
            </template>
            <v-col v-for="(item, i) in questions" :key="i">
                    <v-card
                        class="mx-auto"
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
                                        <template v-if="item.type_like"></template>
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
    </div>
</template>
<script>
export default {
    name: 'home',
    data() {
        return {
            type_heart: '',
            user_name: '',
            show2: true,
            errorHome: false,
            there_is_questions: false,
            likeEn: {
                user_log_id: '',
                post_id: 0,
                type_like : '',
            },
            questions: [],
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
                //Agregamos a las preguntas el atributo 'type_like' para  mostrar el like o dislike
                //En este caso si el usuario no tiene sesion se muestra el dislike
                var newArrayQuest = response.data.questionsRes
                    .map(function(x) {
                        x.type_like='mdi-heart-outline'
                        return x
                    });
                //Donde 'x' tiene los objetos y en cada objeto agregamos el nuevo atributo
                if (this.questions.length === 0) {
                    this.there_is_questions = false
                    console.log("no hay preguntas")
                } else {
                    this.there_is_questions = true
                    let userId = this.$store.getters.currentUser.id
                    var newArrayQuest = response.data.questionsRes
                        .map(function(x) {
                            x.type_like='mdi-heart-outline'
                            x.obj_likes.forEach(element => {
                                if (element.user_id===userId) {
                                    x.type_like='mdi-heart'
                                }
                            });
                            return x
                        });
                        
                    this.questions = newArrayQuest
                    this.$store.commit('setQuestionsRes', this.questions)
                }
            } catch (error) {
                this.errorHome = true
                // console.log("questionsContestadas",error)
            }
        },
        async like(item){
            try {
                //Todo: verificamos que el usuario de clik en boton de like
                if (this.show2) {
                    //Todo: en este caso tememos por defaul a show2 en true
                    //Entonces pasa
                    let user = this.$store.getters.currentUser
                    this.likeEn.user_log_id = user.id
                    this.likeEn.post_id = item.post_id
                    this.likeEn.type_like = 1
                    let response = await axios.post('/api/post/like',this.likeEn)
                    //Enviamos las solicitud y no debuelve un 200 ó 250
                    if (response.status===250) {
                        //Si el status es 250 quiere decir que exite un registro(un like)
                        response = await axios.post('/api/post/dislike',this.likeEn)
                        //Todo: Entonces debemos hacer un dislike
                        if (response.status === 200) {
                            //Si el statu del dislike es 200 debemos poner a show2 en true
                            //Porque sea modificado en el botton a false
                            this.show2 = false
                            this.questionsContestadas()
                        } else {
                            console.log("Error")
                        }
                    } else if (response.status===200) {
                        //Todo: en caso de que status se 200 no habia registro
                        //El show2 pasa hacer false (la considicion esta en el botton 'mirar: show2 = !show2')
                        this.questionsContestadas()
                    }
                } else {
                    let user = this.$store.getters.currentUser
                    this.likeEn.user_log_id = user.id
                    this.likeEn.post_id = item.post_id
                    let response = await axios.post('/api/post/dislike',this.likeEn)
                    if (response.status === 200) {
                        this.show2=true
                        this.questionsContestadas()
                    } else {
                        console.log("Error")
                    }
                }
                
            } catch (error) {
                console.log(error)
                this.$router.push({path: '/register'})
            }
        },
    }
}
</script>
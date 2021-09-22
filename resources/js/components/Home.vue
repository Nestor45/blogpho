<template>
    <div class="container">
        <v-data-iterator :items="questions" :search="search" :sort-by="sortBy.toLowerCase()" :sort-desc="sortDesc" no-data-text="No hay registros"  hide-default-footer>
            <template v-slot:header>
                <v-toolbar dark color="grey darken-1" class="mb-1">
                    <v-text-field v-model="search" clearable flat solo-inverted hide-details prepend-inner-icon="mdi-magnify" label="Buscar pregunta"></v-text-field>
                
                    <template v-if="$vuetify.breakpoint.mdAndUp">
                        <v-spacer></v-spacer>
                        <v-select v-model="sortBy" flat solo-inverted hide-details :items="categories" prepend-inner-icon="mdi-find-replace" label="Filtrar por"></v-select>
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
            </template >
            <template v-slot:default="props">
                <template v-if="errorHome">
                    <v-alert text dense color="teal" icon="mdi-clock-fast" border="left">
                        PARA REALIZAR UNA PREGUNSTA Y UNA MEJOR EXPIENZA PUEDE REGISTRARSE.(falta filtrar peguntas por areas (salud, educación, politica, ambiental, tecnología, familiar, social, laboral)
                    </v-alert>
                </template>
                <v-col v-for="(item, i) in props.items" :key="i">
                    <v-card class="mx-auto" elevation="24" rounded='xl' color="grey darken-1" max-width="800">
                        <v-card-title>
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
                                        <template v-if="item.id_user_piv"><v-icon >{{item.type_like}}</v-icon></template>
                                        
                                        <template v-else ><v-icon >mdi-heart-outline</v-icon></template>
                                        
                                    </v-btn>
                                    <span class="subheading mr-2">{{item.likes}}</span>
                                </v-row>
                            </v-list-item>
                        </v-card-actions>
                    </v-card>
                </v-col>
            </template>
        </v-data-iterator>
        <!-- <template v-else>
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
        </template> -->
    </div>
</template>
<script>
export default {
    name: 'home',
    data() {
        return {
            sortDesc: false,
            errorHome: false,
            there_is_questions: false,
            objUser:{
                user_id_login: '',
            },
            
            likeEn: {
                user_log_id: '',
                post_id: 0,
                type_like : '',
            },
            questions: [],
            categories: [ 
                'Salud', 
                'Educación', 
                'Politica', 
                'Ambiental', 
                'Tecnología', 
                'Familiar', 
                'Social', 
                'Laboral'
            ],
            search: '',
            sortBy: 'id_question',
            sortDesc: false,
            title_question: [],
            filter: {},
        }
    },
    created(){
        this.questionsContestadas()
        
    },
    computed: {
        filteredKeys () {
            return this.questions.filter(title => title !== 'title')
        },
        currentUser() {
            return this.$store.getters.currentUser
        }
    },
    methods: {
        async questionsContestadas(){
            try {
                //Obtenemos las preguntas con sus respuestas
                if (this.$store.getters.currentUser===null) {
                    this.errorHome = true
                    let response = await axios.get('/api/questions/respuesta')
                    //Ahora this.questions tiene las preguntas y sus respuestas
                    console.log("1",this.questions)
                    if (response.data.message === "No hay nada en la BD") {
                        this.there_is_questions = false
                        console.log("no hay preguntas")
                    } else {
                        this.there_is_questions = true
                        this.questions = response.data.questionsRes
                        this.$store.commit('setQuestionsRes', this.questions)
                    }
                } else {
                    console.time()
                    this.objUser.user_id_login = this.$store.getters.currentUser.id
                    let response = await axios.post('/api/post/userIndex',this.objUser)
                    if (response.status === 200) {
                        this.there_is_questions = true
                        this.questions = response.data.questionsRes
                        this.$store.commit('setQuestionsRes', this.questions)
                    } else {
                        console.log("algo salio mal")
                    }
                    console.timeEnd()
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
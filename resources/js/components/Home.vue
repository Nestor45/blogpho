<template>
    <div class="container">
        <template v-if="there_is_questions">
            <v-col v-for="(item, i) in questions" :key="i">
                <v-card
                    class="mx-auto"
                    color="#92C145"
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
                    <v-card-text class="headline font-weight-bold">
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
                                    @click="like(item), show2 = !show2"
                                    fab
                                    icon
                                >  
                                    <v-icon v-if="show2" >mdi-heart-outline</v-icon>
                                    <v-icon v-else >mdi-heart</v-icon>
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
                        No hay publicaciones  
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
            show2: true,
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
        love(){
            console.log("show2",this.show2)
        },
        async questionsContestadas(){
            try {
                let response = await axios.get('/api/questions/respuesta')
                this.questions = response.data.questionsRes
                console.log("no hay preguntas",response.data)
                if (this.questions.length === 0) {
                    this.there_is_questions = false,
                    console.log("no hay preguntas")
                } else {
                    this.there_is_questions = true
                    this.$store.commit('setQuestionsRes', this.questions)
                }
            } catch (error) {
                console.log(error)
            }
        },
        async like(item){
            try {
                if (this.show2) {
                    console.log("show true",this.show2)
                    let user = this.$store.getters.currentUser
                    this.likeEn.user_log_id = user.id
                    this.likeEn.post_id = item.post_id
                    this.likeEn.type_like = 1
                    console.log(this.likeEn)

                    let response = await axios.post('/api/post/like',this.likeEn)
                    if (response.status === 200) {
                        this.questionsContestadas()
                        console.log("like")
                    } else {
                        console.log("Error")
                    }
                }else {
                    console.log("show false",this.show2)
                    let user = this.$store.getters.currentUser
                    this.likeEn.user_log_id = user.id
                    this.likeEn.post_id = item.post_id
                    console.log(this.likeEn)

                    let response = await axios.post('/api/post/dislike',this.likeEn)
                    if (response.status === 200) {
                        this.questionsContestadas()
                        console.log("dislike")
                    } else {
                        console.log("Error")
                    }
                }
                
            } catch (error) {
                console.log(error)
                this.$router.push({path: '/login'})
            }
        }
    }
}
</script>
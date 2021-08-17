<template>
    <div class="container">
        <div class="row justify-content-center">
            <v-card
                lass="mx-auto my-12"
                max-width="450"
            >
                <v-card-text>
                    <v-list-item two-line>
                        <v-list-item-content>
                            <v-list-item-title class="text-h5">
                                VIEW CLIENTE
                            </v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item-avatar color="grey darken-3">
                        <v-img
                        class="elevation-6"
                        alt=""
                        src="https://avataaars.io/?avatarStyle=Transparent&topType=ShortHairShortCurly&accessoriesType=Prescription02&hairColor=Black&facialHairType=Blank&clotheType=Hoodie&clotheColor=White&eyeType=Default&eyebrowType=DefaultNatural&mouthType=Default&skinColor=Light"
                        ></v-img>
                    </v-list-item-avatar>
            
                    <v-list-item-content>
                        <v-list-item-title>{{customer.name}}</v-list-item-title>
                    </v-list-item-content>
                    <v-list>
                        <v-list-item>
                            <v-list-item-action>
                                <v-icon>mdi-phone</v-icon>
                            </v-list-item-action>
                            <v-list-item-content>
                                <v-list-item-title>{{customer.phone}}</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                        <v-divider inset></v-divider>
                        <v-list-item>
                            <v-list-item-action>
                                <v-icon>mdi-email</v-icon>
                            </v-list-item-action>
                
                            <v-list-item-content>
                                <v-list-item-title>{{customer.email}}</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                        
                        <v-divider inset></v-divider>
                        <v-list-item>
                            <v-list-item-action>
                                <v-icon>mdi-web</v-icon>
                            </v-list-item-action>
                
                            <v-list-item-content>
                                <v-list-item-title>{{customer.website}}</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>
                    <v-spacer></v-spacer>
                    <v-dialog v-model="dialog" max-width="400px">
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn
                                v-bind="attrs"
                                v-on="on"
                                text
                                color="teal accent-4"
                            >
                                Edit
                            </v-btn>
                        </template>
                        <v-card>
                            <v-card-title>
                                <span class="text-h5">EDIT CUSTOMER</span>
                            </v-card-title>
                            <v-card-text>
                                <v-container>
                                    <v-row>
                                        <v-col cols="12"  md="11">
                                            <v-text-field v-model="editCustomer.name" label="Name" prepend-icon="mdi-account-alert">{{editCustomer.name}}</v-text-field>
                                        </v-col>
                                        <v-col cols="12"  md="11">
                                            <v-text-field v-model="editCustomer.phone" label="Phone" prepend-icon="mdi-phone">{{editCustomer.phone}}</v-text-field>
                                        </v-col>
                                        <v-col cols="12"  md="11">
                                            <v-text-field v-model="editCustomer.email" label="Email" prepend-icon="mdi-email">{{editCustomer.email}}</v-text-field>
                                        </v-col>
                                        <v-col cols="12"  md="11">
                                            <v-text-field v-model="editCustomer.website" label="Website" prepend-icon="mdi-web">{{editCustomer.website}}</v-text-field>
                                        </v-col>
                                    </v-row>
                                </v-container>
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn
                                    color="blue darken-1"
                                    text
                                    @click="close"
                                    >
                                    Cancel
                                </v-btn>
                                <v-btn
                                    color="blue darken-1"
                                    text
                                    @click="save"
                                    >
                                    Save
                                </v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                </v-card-text>
            </v-card>
        </div>
    </div>
</template>
<script>
export default {
    name: 'view-customer',
    data() {
        return {
            dialog: false,
            editCustomer: {
                id_customer: '',
                name: '',
                phone: '',
                email: '',
                website: ''
            }
        }
    },
    created(){
        this.infoCustomer()
    },
    computed: {
        customer(){
            return this.$store.getters.getCustomer
        }
    },
    methods: {
        infoCustomer(){
            let editCust = this.$store.getters.getCustomer
            this.editCustomer.id_customer = editCust.customer_id
            this.editCustomer.name = editCust.name
            this.editCustomer.phone = editCust.phone
            this.editCustomer.email = editCust.email
            this.editCustomer.website = editCust.website
        },
        close() {
            this.dialog = false
        },
        save() {
            console.log(this.editCustomer)
            this.close()
        }
    }
    
}
</script>
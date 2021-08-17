<template>
    <div class="container">
        <div class="row justify-content-center">
            
        
            <v-data-table
                :headers="headers"
                :items="customers"
                sort-by="calories"
                class="elevation-1"
            >
                <template v-slot:top>
                    <v-toolbar flat>
                        <v-toolbar-title class="text-h5">CUSTOMERS LIST</v-toolbar-title>
                        <v-spacer></v-spacer>
                        <v-btn
                            text
                            color="teal accent-4"
                            @click="newCostomer"
                        >
                            New Customer
                        </v-btn>
                    </v-toolbar>
                </template>
                <v-toolbar-title>My CRUD</v-toolbar-title>
                <template v-slot:[`item.actions`] = "{ item }">
                    <v-icon
                    small
                    class="mr-2"
                    @click="viewCustomer(item)"
                    >
                    mdi-pencil
                    </v-icon>
                    <!-- <v-icon
                    small
                    @click="deleteItem(item)"
                    >
                    mdi-delete
                    </v-icon> -->
                </template>
                <v-toolbar-title>My CRUD</v-toolbar-title>
            </v-data-table>
        </div>
    </div>
</template>
<script>
    export default {
        name : 'list',
        data() {
            return {
                customer: {
                    name: '',
                    phone: '',
                    email: '',
                    website: '',
                    customer_id: ''
                },
                headers: [
                {
                    text: 'Name',
                    align: 'start',
                    sortable: false,
                    value: 'name',
                },
                { text: 'Phone', value: 'phone' },
                { text: 'Email', value: 'email' },
                { text: 'Actions', value: 'actions', sortable: false },
                ],
            }
        },
        created() {
            this.getAllCostomers()
        },
        computed: {
            customers() {
                return this.$store.getters.getCustomers
            }
        },
        methods: {
            async getAllCostomers() {
                try {
                    let response = await axios.get('/api/customers')
                    this.$store.commit('setCustomers', response.data.customers)
                } catch (error) {
                    console.log(error)
                }
            },
            viewCustomer(item) {
                this.customer.name = item.name
                this.customer.phone = item.phone
                this.customer.email = item.email
                this.customer.website = item.website
                this.customer.customer_id = item.customer_id
                this.$store.commit('setCustomer',this.customer)
                this.$router.push(`customers/${this.customer.customer_id}`)
            },
            newCostomer() {
                this.$router.push('/customers/new')
            }
        }
    }
</script>
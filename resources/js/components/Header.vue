<template>
    <!-- <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
        <div class="container"> -->
            <v-card >
                <v-toolbar
                    color="#0D3E67"
                    dark
                    flat
                >
                    <v-app-bar-nav-icon></v-app-bar-nav-icon>

                    <v-toolbar-title>Blog</v-toolbar-title>
            
                    <v-spacer></v-spacer>
            
                    <v-btn icon>
                        <v-icon>mdi-magnify</v-icon>
                    </v-btn>
            
                    <v-btn icon>
                        <v-icon>mdi-dots-vertical</v-icon>
                    </v-btn>

                    <template v-slot:extension>
                        <v-tabs
                            v-model="currentItem"
                            fixed-tabs
                            slider-color="white"
                        >
                            <v-tab
                            v-for="item in items"
                            :key="item"
                            :href="'#tab-' + item"
                            @click="setVista(item)"
                            >
                                {{ item }}
                            </v-tab>
                
                            <v-menu
                            v-if="more.length"
                            bottom
                            left
                            >
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn
                                text
                                class="align-self-center mr-4"
                                v-bind="attrs"
                                v-on="on"
                                >
                                more
                                <v-icon right>
                                    mdi-menu-down
                                </v-icon>
                                </v-btn>
                            </template>
                
                            <v-list class="grey lighten-3">
                                <v-list-item
                                v-for="item in more"
                                :key="item"
                                @click="addItem(item)"
                                >
                                    {{ item }}
                                </v-list-item>
                            </v-list>
                            </v-menu>
                        </v-tabs>
                    </template>
                </v-toolbar>
            </v-card>
        <!-- </div>
    </nav> -->
</template>
<script>
export default {
    name: 'app-header',
    data() {
        return {
            currentItem: 'tab-Web',
            items: [
            'Preguntas', 'Validar', 'Videos', 'Images',
            ],
            more: [
            'News', 'Maps', 'Books', 'Flights', 'Apps',
            ],
            text: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
        }
    },
    methods: {
        addItem (item) {
            console.log(item)
            const removed = this.items.splice(0, 1)
            this.items.push(
                ...this.more.splice(this.more.indexOf(item), 1),
            )
            this.more.push(...removed)
            this.$nextTick(() => { this.currentItem = 'tab-' + item })
            if(item === 'Validar'){
                this.$router.push('/validar');
            }
        },
        setVista (item) {
            console.log(item)
            if(item === 'Preguntas'){
                this.$router.push('/');
            }
            if(item === 'Validar'){
                this.$router.push('/validar');
            }
        }
    },
    computed: {

    }
}
</script>
<template>
    <div class="container">
        <v-card-text class="py-0">
            <v-timeline dense>
            <v-slide-x-reverse-transition
                group
                hide-on-leave
            >
                <v-timeline-item
                v-for="item in items"
                :key="item.id"
                :color="item.color"
                small
                fill-dot
                >
                <template v-slot:icon>
                    <v-avatar>
                        <img src="https://avataaars.io/?avatarStyle=Transparent&topType=ShortHairShortCurly&accessoriesType=Prescription02&hairColor=Black&facialHairType=Blank&clotheType=Hoodie&clotheColor=White&eyeType=Default&eyebrowType=DefaultNatural&mouthType=Default&skinColor=Light">
                    </v-avatar>
                </template>
                <v-card
                    :color="item.color"
                    dark
                >
                    <v-card-text class="white text--primary">
                        <p>¿Cuál es la noción jurídico substancial del delito?</p>
                        <v-btn
                            :color="item.color"
                            class="mx-0"
                            outlined
                        >
                            Publicar
                        </v-btn>
                        <v-btn
                            :color="item.color"
                            class="mx-0"
                            outlined
                        >
                            Eliminar
                        </v-btn>
                    </v-card-text>
                </v-card>
                </v-timeline-item>
            </v-slide-x-reverse-transition>
            </v-timeline>
        </v-card-text>
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
            items: [
                {
                    id: 1,
                    color: 'info',
                    icon: ICONS.info,
                },
            ],
        }
    }
}
</script>
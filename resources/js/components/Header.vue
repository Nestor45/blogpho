<template>
<div></div>
</template>
<script>
export default {
    name: 'app-header',
    data() {
        
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
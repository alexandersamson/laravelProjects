<template>
    <span>
        <small>
            <a :href="this.url" :disabled="this.active == true" class="v-link" >{{this.name}}</a>
        </small>
    </span>
</template>

<script>
    export default {
        props:[
            'url',
            'name',
            'active'
        ],
        mounted() {
            //
        },
    }
</script>

<style scoped>
    .v-link{
        text-wrap: none;
    }
</style>

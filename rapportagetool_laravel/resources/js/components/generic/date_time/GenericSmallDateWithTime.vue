<template>
    <span>
        <small class="v-style">
            <a :href="'/searchbydate/' + dtLink" class="v-link" >{{formatDateTime}}</a>
        </small>
    </span>
</template>

<script>
    export default {
        props:[
            'datetime',
        ],
        data(){
            return {
                curDate: new Date(this.datetime)
            }
        },
        mounted() {
            //
        },
        methods:{
            addZero(i){
                if (i < 10) {
                    i = "0" + i;
                }
                return i;
            }
        },
        computed: {
            formatDateTime: function () {
                return this.addZero(this.curDate.getDate()) +
                    "-" +
                    this.addZero((this.curDate.getMonth() + 1)) +
                    "-" +
                    this.curDate.getFullYear() +
                    " " +
                    this.addZero(this.curDate.getHours()) +
                    ':' +
                    this.addZero(this.curDate.getMinutes());
                //D-M-Y HH:MM
            },
            dtLink: function () {
                return this.curDate.getFullYear() + "-" + this.addZero((this.curDate.getMonth() +1)) + "-" + this.addZero(this.curDate.getDate());
            }
        }
    }
</script>

<style scoped>
    .v-style{
        text-wrap: none;
    }
    .v-link{
        text-wrap: none;
    }
</style>

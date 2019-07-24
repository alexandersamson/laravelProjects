<template>
    <div class="">
        <table class="table table-sm">
            <tr v-if="objs.length">
                <th class="small bg-primary text-white font-weight-normal">
                    {{title}}
                </th>
                <th class="small bg-primary text-white font-weight-normal text-right">
                    View
                </th>
            </tr>
            <tr class="small bg-primary-light" v-for="obj in objs" :key="obj.id">
                <td>
                    <b-link v-on:click="processClick(obj.id)" href="#">{{obj.name}}</b-link>
                </td>
                <td class="text-right">
                    <b-link class="" :href="obj.url">view</b-link>
                </td>
            </tr>
            <tr class="py-0" v-if="objs.length">
                <th class="py-0 bg-primary text-light small font-weight-normal">
                    <span v-if="objs.length > 10">{{objs.length}} or more results. Please try being more specific.</span>
                    <span v-else-if="objs.length > 1">{{objs.length}} results</span>
                    <span v-else>{{objs.length}} result</span>
                </th>
                <th class="py-0 bg-primary text-white small font-weight-normal text-right">

                </th>
            </tr>
        </table>
    </div>
</template>

<script>

    export default {
        props:[
            'objs',
            'title'
        ],
        data(){
            return {
                clickedObjId: 0,
            }
        },
        mounted() {
            //
        },
        methods:{
            deleteItem: function(valueId) {
                //
            },
            processClick: function (value){
                this.clickedObjId = value;
                this.$emit('handle-search-list-click', this.clickedObjId)
            }
        },
        computed: {
            //
        }
    }
</script>

<style scoped>
    .bg-primary-light{
        background-color: rgba(0, 127, 255, 0.05);
    }
    .bg-primary-light:hover{
        background-color: rgba(0, 127, 255, 0.12);
    }

</style>
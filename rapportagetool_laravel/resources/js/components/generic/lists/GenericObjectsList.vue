<!--Uses from Obj:-->
<!-- -id         (inherent to object-->
<!-- -name       (inherent to object-->
<!-- -show_link  (injected into Obj via controller)-->
<!-- -url        (injected into Obj via controller)-->

<!--Uses also:-->
<!-- -title (string)-->

<template>
    <div class="">
        <table class="table table-sm mb-0">
            <tr v-if="objs.length">
                <th class="py-0 small bg-primary text-white font-weight-normal text-left">
                </th>
                <th class="py-0 small bg-primary text-white font-weight-normal text-right">
                </th>
            </tr>
            <tr class="small bg-primary-light" v-for="obj in objs" :key="obj.id">
                <td class="text-left">
                    <b-link  :href="obj.url"><b>{{obj.name}}</b></b-link>
                </td>
                <td class="text-right">
                    <b-link v-if="obj.show_link !== false" class="text-danger" v-on:click="processClick(obj.id)">remove</b-link>
                </td>
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
                this.$emit('handle-objects-list-click', this.clickedObjId)
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
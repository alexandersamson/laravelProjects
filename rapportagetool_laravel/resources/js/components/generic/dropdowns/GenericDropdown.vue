<template>
    <div class="dropdown">
        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            {{getTitle}}
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <div v-for="dropdownValue in dropdownValues" :key="dropdownValue.id">
                <a class="dropdown-item" v-on:click="selectItem(dropdownValue.id)" :class="isActive(dropdownValue.id)" href="#">{{dropdownValue.name}}</a>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        props:[
            'category',
            'id',
            'element',
        ],
        data(){
            return {
                dropdownValues: [],
                activeValue: 1,
                activeTitle: '',
            }
        },
        mounted() {
            this.getDropDownData();
        },
        methods:{
            getDropDownData() {
                const self = this;
                axios.post('/axios/get-dropdown-values', {
                    category: self.category,
                    id: self.id,
                    element: self.element,
                })
                    .then(function (response) {
                        self.dropdownValues = response.data.values;
                        self.activeValue = response.data.active;
                        self.activeTitle =  self.dropdownValues[self.activeValue].name

                    })
                    .catch(function (error) {
                        self.activeTitle = error;
                    });
            },
            isActive: function(valueId) {
                if(this.activeValue === valueId){
                    return 'active'
                }
                return '';
            },
            selectItem: function(valueId) {
                const self = this;
                axios.post('/axios/update-dropdown-value', {
                    category: self.category,
                    id: self.id,
                    element: self.element,
                    value: valueId
                })
                    .then(function (response) {
                        self.getDropDownData()
                    })
                    .catch(function (error) {
                        self.activeTitle = error;
                    });
            },

        },
        computed: {
            getTitle: function(){
                let result = this.dropdownValues.find(obj => {
                    return obj.id === this.activeValue
                });
                if(result) {
                    return result.name;
                }
            },
        }
    }
</script>

<style scoped>

</style>
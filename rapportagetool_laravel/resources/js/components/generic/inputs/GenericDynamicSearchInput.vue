<template>
    <form ref="form" @submit.stop.prevent="handleSubmit">
        <b-form-group>
            <b-form-input
                    id="name-input"
                    placeholder="Search"
                    v-debounce:250ms="getSearchValues"
            ></b-form-input>
        </b-form-group>
    </form>
</template>

<script>
//DynamicSearchController takes:
    //categories
    //element
    //searchString
    export default {
        props:[
            'searchCategories',
            'searchElement'
        ],
        data(){
            return{
                searchValues:[],
                searchResultsTitle: 'Search results',
            };
        },
        mounted(){
            this.getSearchValues('#recent');
        },
        methods:{
            getSearchValues: function(searchString) {
                if(searchString.length < 1){
                    return;
                }
                const self = this;
                axios.post('/axios/get-search-values', {
                    categories: this.searchCategories,
                    id: this.id,
                    element: this.searchElement,
                    searchString: searchString
                })
                    .then(function (response) {
                        self.searchValues = response.data;
                        self.$emit('get-search-values', self.searchValues)
                    })
                    .catch(function (error) {
                        self.activeTitle = error;
                    });
            },
        }

    }
</script>
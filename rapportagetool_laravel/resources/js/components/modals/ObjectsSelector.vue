<template>
    <div>
        <b-button class="btn btn-block bg-primary border-0" v-b-modal="'modal' + sourceCat + sourceId + targetCat">Add {{targetCat}}</b-button>
        <generic-objects-list :title="objectsListTitle" :objs="selectedObjects" @handle-objects-list-click="handleObjectsListClick"></generic-objects-list>
        <b-modal
                :id="'modal' + sourceCat + sourceId + targetCat"
                ref="modal"
                title="Search"
                @show="resetModal"
                @hidden="resetModal"
                @ok="handleOk"
        >
            <generic-dynamic-search-input :search-categories="[targetCat]" :search-element="targetCat" @get-search-values="processSearchItems"></generic-dynamic-search-input>
            <generic-search-list :title="searchResultsTitle" :objs="searchValues" @handle-search-list-click="handleSearchListClick"></generic-search-list>
        </b-modal>
    </div>
</template>

<script>
    export default {
        props: [
            'sourceCat',
            'sourceId',
            'targetCat',
        ],
        data() {
            return {
                searchValues: [],
                selectedObjects: [],
                searchResultsTitle: 'Search results',
                objectsListTitle: 'Selected',
            }
        },
        mounted(){
            this.getObjectsList();
        },
        methods: {
            resetModal(){
                //
            },
            getObjectsList(){
                const self = this;
                axios.post('/axios/get-objects-list', {
                    targetCat: self.targetCat,
                    sourceCat: self.sourceCat,
                    sourceId: self.sourceId
                })
                    .then(function (response) {
                        self.selectedObjects = response.data.objs;
                        self.objectsListTitle = response.data.title;
                        self.handleSubmit();
                    })
                    .catch(function (error) {
                        console.log(error);
                        self.activeTitle = error;
                    });
            },
            processSearchItems(e){
                this.searchValues = e.objs;
                this.searchResultsTitle = e.title;

            },
            handleSearchListClick(e){
                const self = this;
                axios.post('/axios/add-to-list', {
                    targetCat: self.targetCat,
                    id: e,
                    sourceCat: self.sourceCat,
                    sourceId: self.sourceId
                })
                    .then(function (response) {
                        console.log(response.data);
                        self.selectedObjects = response.data.objs;
                        self.objectsListTitle = response.data.title;
                        self.handleSubmit();
                    })
                    .catch(function (error) {
                        console.log(error);
                        self.activeTitle = error;
                    });

            },
            handleObjectsListClick(e){
                const self = this;
                axios.post('/axios/remove-from-list', {
                    targetCat: self.targetCat,
                    id: e,
                    sourceCat: self.sourceCat,
                    sourceId: self.sourceId,
                })
                    .then(function (response) {
                        // console.log(response);
                        self.selectedObjects = response.data.objs;
                        self.objectsListTitle = response.data.title;
                        self.handleSubmit();
                    })
                    .catch(function (error) {
                        console.log(error);
                        self.activeTitle = error;
                    });

            },
            handleOk(bvModalEvt) {
                // Prevent modal from closing
                bvModalEvt.preventDefault();
                // Trigger submit handler
                this.handleSubmit();
            },
            handleSubmit() {
                // Hide the modal manually
                this.$nextTick(() => {
                    this.$refs.modal.hide();
                })
            }
        }
    }
</script>
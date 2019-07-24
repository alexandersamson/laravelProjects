<template>
    <div class="container">
        <div class="row justify-content-left">
            <div class="col-md-12">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item">
                            <a @click="fetchCasenotes(pagination.prev_page_url)" class="page-link" href="#">&lt;</a>
                        </li>
                        <li class="page-item disabled">
                            <span class="page-link">{{pagination.current_page}} of {{pagination.last_page}}</span>
                        </li>
                        <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item">
                            <a @click="fetchCasenotes(pagination.next_page_url)" class="page-link" href="#">&gt;</a>
                        </li>
                    </ul>
                </nav>
                <div v-for="obj in objs" v-bind:key="obj.id">
                    <div class="card mb-2">
                        <div class="card-header pb-0 pt-1 px-2">
                            <span class="float-left">
                                #{{ obj.id }} | {{ obj.name }} |
                                <generic-small-date-with-time :datetime="obj.created_at"></generic-small-date-with-time> |
                                <generic-small-link :url="'/users/'+obj.creator.id" :name="obj.creator.name" :active="true" ></generic-small-link>
                            </span>
                            <span class="float-right">
                                <generic-small-link :url="'/casenotes/'+obj.id+'/edit'" :name="'Edit'" :active="true" ></generic-small-link>
                                <generic-small-link :url="'/casenotes/'+obj.id+'/delete'" :name="'Delete'" :active="true" ></generic-small-link>
                            </span>
                        </div>

                        <div class="card-body pb-0 pt-1 px-2" v-html="obj.body">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['parentId'],
        mounted() {
            console.log('Component Casenotes mounted.')
        },
        data(){
            return {
                objs: [],
                obj:{
                    id: '',
                    name: '',
                    created_at: '',
                    creator_id: 0,
                    creator: [],
                    body: '',
                }, casenote_id: '',
                pagination:{},
                edit: false,
            }
        },
        created(){
            this.fetchCasenotes();
        },
        methods:{
            fetchCasenotes(page_url){
                let vm = this;
                page_url = page_url || '/api/casenotes/' + this.parentId;
                fetch(page_url)
                    .then(res=> res.json())
                    .then(res =>{
                        console.log(res);
                        this.objs = res.data;
                        vm.makePagination(res.meta, res.links);

                    })
                    .catch(err => console.log(err));
            },
            makePagination(meta, links){
                this.pagination = {
                    current_page: meta.current_page,
                    last_page: meta.last_page,
                    next_page_url: links.next,
                    prev_page_url: links.prev,
                };
            }
        }
    }
</script>

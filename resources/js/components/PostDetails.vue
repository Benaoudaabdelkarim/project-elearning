<template>
    <div class="container">
        <div class="row my-4">
            <div class="col-md-8 mx-auto mt-5">
                <h2 class="card-header">{{post.title}}</h2>
                <p class="p-2">
                    <span class="badge badge-danger">
                        {{post.user}}
                    </span>
                    <span class="badge badge-info">
                        {{post.created_at}}
                    </span>
                    <span class="badge badge-success">
                        {{post.category}}
                    </span>
                </p>
                <div class="card-img-top">
                    <img style="width:100%; height:400px" :src="post.photo" alt="" class="rounded shadow-sm img-fluid mr-2">
                </div>
                <div class="card-body">
                    <div class="media">
                        <div class="media-body">
                            <p class="lead">{{post.body}}</p>
                        </div>
                    </div>
                </div>
                <div class="row my-3">
                    <div class="col-md-12">
                        <div class="media shadow my-4 p-4" v-if="logged">
                            <div class="media-body">
                                <h3 class="my-3 text-dark">add a comment</h3>
                                <div class="form-group">
                                    <label for="">comments</label>
                                    <textarea 
                                        class="form-control" 
                                        cols="30" rows="3"
                                        v-model="comment">
                                        </textarea>
                                </div>
                                <button type="button" 
                                class="btn btn-primary"
                                @click="addComment(post.id)">
                                    Add
                                </button>
                            </div>
                        </div>
                        <div class="media shadow p-4 my-4"  v-else>
                            <div class="media-body">
                                <router-link to="/login">connect to comment</router-link>
                            </div>
                        </div>
                        <h3 class="text-info mb-3">
                            Comments <span class="badge badge-dark p-2">
                                {{post.comments_count}}
                            </span>
                        </h3>
                        <div class="media my-4 p-4 shadow"
                            v-for="(comment, index) in post.comments"
                            :key="index">
                            <div class="media-body">
                                <span class="text-danger">
                                    {{comment.user}} | {{comment.created_at}}
                                </span>
                                <p class="lead">
                                    {{comment.body.substr(0, 100)}}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default{
        data(){
            return {
                post : '',
                comment : '',
                logged: User.isLogged().logged
            }
        },
        methods:{
            addComment(id){
                axios.post('/api/comments', {
                    post_id: id,
                    body: this.comment,
                    user_id: User.isLogged().id
                    
                }).then(response => {
                    this.post.comments_count +=1;
                    this.post.comments.unshift(response.data);
                    this.comment= null;
                }).catch(err => console.log(err));
            }
        },
        created(){
            axios.get(`/api/posts/${this.$route.params.slug}`)
                .then(response => {
                    console.log(response.data);
                    this.post = response.data.post;
                }).catch(err => console.log(err));
        }
    }
</script>

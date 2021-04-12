<template>
    <div class="container-fluid">
        <div class="row my-4">
            
        </div>
        <div class="row my-4">
            <div class="col-md-12">
                <a href="#" data-target="#addPost" data-toggle="modal" class="btn btn-sm btn-success text-white mb-2">
                    <i class="fa fa-plus">Add a post</i>
                </a>
                <a href="#" data-target="#addCategory" data-toggle="modal" class="btn btn-sm btn-success text-white mb-2">
                    <i class="fa fa-plus">Add a catgoey</i>
                </a>
                <a href="#" data-target="#addSlide" data-toggle="modal" class="btn btn-sm btn-success text-white mb-2">
                    <i class="fa fa-plus">Add a Slide</i>
                </a>
                <VueFuse
                    placeholder="Search"
                    event-name="results"
                    :list="posts"
                    :keys="['title','added','category.name']"
                    class="form-control"
                />
                <table class="table">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>category</th>
                            <th>titre</th>
                            <th>description</th>
                            <th>image</th>
                            <th>ajouté par</th>
                            <th>le</th>
                            <th>action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(post, index) in results" :key="index">
                            <td>{{post.id}}</td>
                            <td>{{post.category.name}}</td>
                            <td>{{post.title}}</td>
                            <td>{{post.body.substr(0, 100)}}...</td>
                            <td>
                                <img :src="post.photo" 
                                alt="" 
                                height="60" width="60"
                                srcset=""
                                class="img-fluid mr-2 rounded shadow-sm">
                            </td>
                            <td>{{post.user.name}}</td>
                            <td>{{post.added}}</td>
                            <td>
                                <router-link :to="post.path"
                                class="btn btn-primary mr-1 btn-sm">
                                    <div class="fa fa-eye"></div>
                                </router-link>
                                <router-link :to="{path : 'post/edit/' + post.slug}"
                                class="btn btn-warning mr-1 btn-sm">
                                    <div class="fa fa-edit"></div>
                                </router-link>
                                <a @click="deletePost(post.slug)" class="btn btn-danger btn-sm text-white">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <EmailAdmin />
            <AddPost @added="postAdded" />
            <AddCategory />
            <AddSlide/>
            
            
        </div>
    </div>
</template>

<script>
import AddPost from './AddPost';
import AddCategory from './AddCategory';
import SlideAdmin from './SlideAdmin';
import AddSlide from './AddSlide';
import EmailAdmin from './EmailAdmin';
import VueFuse from './VueFuse.vue';

export default {
    data(){
        return{
            posts : [],
            categories : {},
            slides : {},
            results: [],
            loading : true
        }
    },
    components:{
        AddPost,
        AddCategory,
        SlideAdmin,
        AddSlide,
        EmailAdmin,
        VueFuse
    },
    created(){
        this.auth();
        this.getCategories();
        this.getSlides();
        this.search();
    },
    methods:{
        auth(){
            if(User.isLogged() && User.isAdmin()){
            this.getPosts();
            }else{
                this.$router.push({name:"home"});
            }
        },
        getPosts(){
            axios.get('/api/posts')
                .then(response => {
                    console.log(response.data);
                    this.posts = response.data;
                })
                .catch(err => console.log(err));
        },
        getCategories(){
            axios.get('/api/categories')
            .then(response => {
                console.log(response.data);
                this.categories = response.data.categories;
            })
            .catch(err => console.log(err));
        },
        getSlides(){
            axios.get('/api/slides')
            .then(response => {
                console.log(response.data);
                this.slides = reponse.data.slides;
            })
            .catch(err => console.log(err));
        },
        postAdded(){
            this.getPosts();
        },
        search(){
            this.$on('results', results => {
                this.results = results
            })
        },
        deletePost(slug) {
            Swal.fire({
                title: "are you sur?",
                text: "you can't recupirate this article",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "cancel",
                confirmButtonText: "delete!"
            }).then(result => {
                if (result.value) {
                axios
                    .delete(`/api/posts/${slug}`)
                    .then(response => {
                    Swal.fire({
                        position: "center",
                        type: "success",
                        title: response.data.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                    this.getPosts();
                    })
                    .catch(error => console.log(error));
                }
            });
        }
    }
}
</script>
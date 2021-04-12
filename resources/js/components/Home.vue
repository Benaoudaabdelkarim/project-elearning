<template>
    <div class="container-fuild">
        <Slider></Slider>
        <div class="row my-4">
            <Categories></Categories>
            <div class="col-md-6 mt-5">
                <VueFuse
                    placeholder="Search"
                    event-name="results"
                    :list="posts"
                    :keys="['title','added','category.name']"
                    class="form-control"
                />
                <div class="card">
                    <div class="card-header">Articles</div>
                    
                    <div class="card-body"
                        v-for="(post,index) in results"
                        :key="index"
                    >
                        <div class="media">
                            <img :src="post.photo" class="rounded shadow-sm img-fluid mr-2" alt="" srcset="">
                            <div class="media-body">
                                <router-link :to="post.path">
                                    <h3>{{post.title}}</h3>
                                </router-link>
                                <p>
                                    <span class="text-default">
                                        {{post.user.name}}
                                    </span>
                                    <span class="text-danger">
                                        {{post.added}}
                                    </span>
                                </p>
                                <p class="lead">{{post.body.substr(0,200)}}...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <Users></Users>
        </div>
    </div>
</template>

<script>
    import Categories from './Categories.vue';
    import Users from './Users.vue';
    import Slider from './Slider.vue';
    import VueFuse from './VueFuse.vue';

    export default {
        data(){
            return{
                posts : [],
                results: [],
            }
        },
        components : {
            Categories,
            Users,
            Slider,
            VueFuse
        },
        created () {
            this.getPosts();
            this.search();
        },
        methods: {
            getPosts(){
                axios.get('/api/posts')
                .then(response => {
                    console.log(response.data);
                    this.posts = response.data;
                })
                .catch(err => console.log(err));
            },
            search(){
            this.$on('results', results => {
                this.results = results
            })
        },
        }
    }
</script>

<style scoped>
    img {
    width: 200px;
    height: 200px;
    }
</style>
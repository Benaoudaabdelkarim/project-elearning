<template>
    <div>
        <div class="container">
            <div class="row my-4">
                <h1>profile</h1>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row my-4">
                <div class="col-4 mt-5">
                    <div class="card">
                        <h2 class="card-header">Informations</h2>
                        <div class="card-body">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <h3> {{user.name}} </h3>
                                </li>
                                <li class="list-group-item">
                                    <h3> {{user.slug}} </h3>
                                </li>
                                <li class="list-group-item">
                                    <h3> {{user.email}} </h3>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col mt-5">
                    <div class="card">
                        <div class="card-header">Articles</div>
                        <div class="card-body"
                            v-for="(post,index) in user.posts"
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
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return {
            user : '',
            logged: User.isLogged().logged,
        }
    },
   created(){
        axios.get(`/api/users/${this.$route.params.slug}`)
            .then(response => {
                this.user = response.data.user;
            }).catch(err => console.log(err));
    },
}
</script>
<style scoped>
    img {
    width: 200px;
    height: 200px;
    }
</style>
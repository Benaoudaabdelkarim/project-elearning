<template>
    <div class="container">
        <div class="row my-4">
            <div class="col-md-8 mx-auto mt-5">
                <h2 class="card-header">{{email.subject}}</h2>
                <p class="p-2">
                    <span class="badge badge-danger">
                        {{email.name}}
                    </span>
                    <span class="badge badge-info">
                        {{email.created_at}}
                    </span>
                    <span class="badge badge-success">
                        {{email.number}}
                    </span>
                    <span class="badge badge-success">
                        {{email.email}}
                    </span>
                </p>
                <div class="card-body">
                    <div class="media">
                        <div class="media-body">
                            <p class="lead">{{email.message}}</p>
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
                logged: User.isLogged().logged,
                email : ''
            }
        },
        created(){
            axios.get(`/api/emails/${this.$route.params.slug}`)
                .then(response => {
                    console.log(response.data);
                    this.email = response.data;
                }).catch(err => console.log(err));
        }
    }
</script>

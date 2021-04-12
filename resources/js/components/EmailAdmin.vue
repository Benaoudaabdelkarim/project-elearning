<template>
    <div class="container-fluid mt-5">
        <div class="row my-4">
            <div class="col-md-12">
                <VueFuse
                    placeholder="Search"
                    event-name="results"
                    :list="emails"
                    :keys="['name','email']"
                    class="form-control"
                />
                <table class="table">
                    <thead>
                        <tr>
                            <th>name</th>
                            <th>email</th>
                            <th>subject</th>
                            <th>number</th>
                            <th>message</th>
                            <th>date</th>
                            <th>action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(email, index) in results" :key="index">
                            <td>{{email.name}}</td>
                            <td>{{email.email}}</td>
                            <td>{{email.subject}}</td>
                            <td>{{email.number}}</td>
                            <td>{{email.message}}</td>
                            <td>{{email.added}}</td>
                            <td>
                                <router-link :to="email.path"
                                class="btn btn-primary mr-1 btn-sm">
                                    <div class="fa fa-eye"></div>
                                </router-link>
                                <a @click="deleteEmail(email.slug)" class="btn btn-danger btn-sm text-white">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import VueFuse from './VueFuse.vue'

export default {
    components:{
        VueFuse
    },
    data(){
        return{
            emails :[],
            results: [],
        }
    },
    created () {
        this.getEmails();
        this.search();
    },
    methods:{
        getEmails(){
            axios.get('/api/emails')
                .then(response => this.emails = response.data)
                .catch(err => console.log(err));
        },
        search(){
            this.$on('results', results => {
                this.results = results
            })
        },
        deleteEmail(slug) {
            Swal.fire({
                title: "are you sur?",
                text: "you can't recupirate this email",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "cancel",
                confirmButtonText: "delete!"
            }).then(result => {
                if (result.value) {
                axios
                    .delete(`/api/emails/${slug}`)
                    .then(response => {
                    Swal.fire({
                        position: "center",
                        type: "success",
                        title: response.data.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                    this.getEmails();
                    })
                    .catch(error => console.log(error));
                }
            });
        }
    }
}
</script>
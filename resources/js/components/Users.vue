<template>
    <div class="col mt-5">
        <div class="card">
            <h2 class="card-header">Members</h2>
            <div class="card-body">
                <ul class="list-group">
                    <li class="list-group-item"
                        v-for="(user,index) in users"
                        :key="index"
                    >
                        <router-link :to="user.path">
                            {{user.name}}
                        </router-link>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>


<script>
export default {
    data(){
        return{
            users : {}
        }
    },
    created () {
        axios.get('/api/users')
            .then(response => {
                    console.log(response.data);
                    this.users = response.data;
                })
                .catch(err => console.log(err));
    }
}
</script>
<template>
  
</template>

<script>
export default {
    data(){
        return{
            slides : []
        }
    },
    created () {
        axios.get('/api/slides')
            .then(response => this.slides = response.data)
            .catch(err => console.log(err));
    }
}
</script>
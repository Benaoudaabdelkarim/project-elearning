<template>
    <div class="row">
      <div class="col-md-4" v-for="(slide, index) in slides" :key="index">
        <div class="thumbnail">
          <a href="/w3images/lights.jpg">
            <img :src="slide.photo" alt="Lights" style="width:100%">
            <div class="row">
              <h3>
                {{slide.title}}
              </h3>
            </div>
            <div class="caption">
              <p>{{slide.body.substr(0, 10)}}</p>
            </div>
          </a>
        </div>
      </div>
    </div>
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

<style scoped>
    img {
    width: 300px;
    height: 200px;
    }
</style>
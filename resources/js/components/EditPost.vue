<template>
  <div class="container">
    <div class="row my-4">
      <div class="col-md-8 mx-auto mt-5">
        <div class="card bg-light">
          <h3 class="card-header" id="exampleModalCenterTitle">Modifier un article</h3>
          <div class="card-body">
            <form @submit="updatePost" enctype="multipart/form-data">
              <div class="form-group">
                <label for>Catégorie</label>
                <option value disabled selected>Veuillez choisir une catégorie</option>
                <select v-model="post.category" class="form-control" name="category" required id>
                  <option
                    :value="category.id"
                    v-for="(category,index) in categories"
                    :key="index"
                  >{{category.name}}</option>
                </select>
              </div>
              <div class="form-group">
                <label for>Titre*</label>
                <input
                  type="text"
                  name="title"
                  id
                  v-model="post.title"
                  class="form-control"
                  placeholder="Titre"
                  required
                  aria-describedby="helpId"
                />
              </div>
              <div class="form-group">
                <label for></label>
                <textarea
                  v-model="post.body"
                  class="form-control"
                  name="body"
                  id
                  rows="5"
                  placeholder="Description"
                ></textarea>
              </div>
              <div class="form-group">
                <label for>Photo*</label>
                <input
                  type="file"
                  v-on:change="onImageChange"
                  class="form-control-file"
                  name="image"
                  id="image"
                  placeholder
                  aria-describedby="fileHelpId"
                />
              </div>
              <button type="submit" class="btn btn-primary">Valider</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      post: { title: "", body: "", category: "" },
      categories: [],
      image: null
    };
  },
  created() {
    this.getPost();
    this.getCategories();
  },
  methods: {
    onImageChange(e) {
      console.log(e.target.files[0]);
      this.image = e.target.files[0];
    },
    getCategories() {
      axios
        .get("/api/categories")
        .then(response => (this.categories = response.data.categories))
        .catch(err => console.log(err));
    },
    getPost() {
      axios
        .get(`/api/posts/${this.$route.params.slug}`)
        .then(res => {
          this.post = res.data.post;
          this.image = res.data.post.photo;
        })
        .catch(err => console.log(err));
    },
    updatePost(e) {
      e.preventDefault();
      const config = {
        headers: { "content-type": "multipart/form-data" }
      };
      let formData = new FormData();
      formData.append("image", this.image);
      formData.append("title", this.post.title);
      formData.append("body", this.post.body);
      formData.append("category_id", this.post.category);
      formData.append("user_id", User.isLogged().id);
      formData.append("_method", "put");
      axios
        .post(`/api/posts/${this.post.slug}`, formData, config)
        .then(res => {
          this.post.title = "";
          this.post.body = "";
          this.post.category = "";
          this.image = null;
          Swal.fire({
            position: "center",
            icon: "success",
            title: "Article modifié",
            showConfirmButton: false,
            timer: 1500
          });
          this.$router.push({ name: "admin" });
        })
        .catch(err => console.log(err));
    }
  }
};
</script>
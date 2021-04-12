<template>
  <div
    class="modal fade"
    id="addPost"
    tabindex="-1"
    role="dialog"
    aria-labelledby="addPost"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalCenterTitle">Ajouter un article</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form @submit="addPost" enctype="multipart/form-data">
            <div class="form-group">
              <label for>Catégorie</label>
              <option value disabled selected>Veuillez choisir une catégorie</option>
              <select v-model="category" class="form-control" name="category" required id>
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
                v-model="title"
                class="form-control"
                placeholder="Titre"
                required
                aria-describedby="helpId"
              />
            </div>
            <div class="form-group">
              <label for></label>
              <textarea
                v-model="body"
                class="form-control"
                name="body"
                id
                rows="5"
                placeholder="Description"
              ></textarea>
            </div>
            <div class="form-group">
              <label for>file*</label>
              <input
                type="file"
                required
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
</template>

<script>
export default {
  data() {
    return {
      title: "",
      body: "",
      category: "",
      categories: [],
      image: null
    };
  },
  created() {
    axios
      .get("/api/categories")
      .then(response => (this.categories = response.data.categories))
      .catch(err => console.log(err));
  },
  methods: {
    onImageChange(e) {
      console.log(e.target.files[0]);
      this.image = e.target.files[0];
    },
    addPost(e) {
      e.preventDefault();
      const config = {
        headers: { "content-type": "multipart/form-data" }
      };
      let formData = new FormData();
      formData.append("image", this.image);
      formData.append("title", this.title);
      formData.append("body", this.body);
      formData.append("category_id", this.category);
      formData.append("user_id", User.isLogged().id);
      axios
        .post("api/posts", formData, config)
        .then(res => {
          $("#addPost").modal("hide");
          this.title = "";
          this.body = "";
          this.category = "";
          this.image = null;
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Article ajouté',
            showConfirmButton: false,
            timer: 1500
          });
          this.$emit("added");
        })
        .catch(err => console.log(err));
    }
  }
};
</script>
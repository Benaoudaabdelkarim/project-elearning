<template>
  <div
    class="modal fade"
    id="addSlide"
    tabindex="-1"
    role="dialog"
    aria-labelledby="addSlide"
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
          <form @submit="addSlide" enctype="multipart/form-data">
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
              <label for>Photo*</label>
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
      image: null
    };
  },
  created() {
  },
  methods: {
    onImageChange(e) {
      console.log(e.target.files[0]);
      this.image = e.target.files[0];
    },
    addSlide(e) {
      e.preventDefault();
      const config = {
        headers: { "content-type": "multipart/form-data" }
      };
      let formData = new FormData();
      formData.append("image", this.image);
      formData.append("title", this.title);
      formData.append("body", this.body);
      axios
        .post("api/slides", formData, config)
        .then(res => {
          $("#addSlide").modal("hide");
          this.title = "";
          this.body = "";
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
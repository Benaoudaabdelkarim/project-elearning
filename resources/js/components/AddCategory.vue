<template>
  <div
    class="modal fade"
    id="addCategory"
    tabindex="-1"
    role="dialog"
    aria-labelledby="addCategory"
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
          <form @submit="addCategory" enctype="multipart/form-data">
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
            <button type="submit" class="btn btn-primary">Submit</button>
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
      categories: [],
    };
  },
  created() {
    axios
      .get("/api/categories")
      .then(response => (this.categories = response.data.categories))
      .catch(err => console.log(err));
  },
  methods: {
    addCategory(e) {
      e.preventDefault();
      const config = {
        headers: { "content-type": "multipart/form-data" }
      };
      let formData = new FormData();
      formData.append("name", this.title);
      axios
        .post("api/categories", formData, config)
        .then(res => {
          $("#addCategory").modal("hide");
          this.title = "";
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
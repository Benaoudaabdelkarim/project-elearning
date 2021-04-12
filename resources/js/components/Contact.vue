<template>
    <div class="container">
        <h2 class="text-center">Contact Form</h2>
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6 pb-5">
                <!--Form with header-->

                <form  @submit="addEmail">
                    <div class="card border-primary rounded-0">
                        <div class="card-header p-0">
                            <div class="bg-info text-white text-center py-2">
                                <h3><i class="fa fa-envelope"></i> Contact us</h3>
                                <p class="m-0">get in quote</p>
                            </div>
                        </div>
                        <div class="card-body p-3">

                            <!--Body-->
                            <div class="form-group">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-user text-info"></i></div>
                                    </div>
                                    <input type="text" v-model="name" class="form-control" id name="name" placeholder="name" required aria-describedby="helpId">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-envelope text-info"></i></div>
                                    </div>
                                    <input type="email" v-model="email" class="form-control" id name="email" placeholder="jhonDoe@gmail.com" required  aria-describedby="helpId">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-user text-info"></i></div>
                                    </div>
                                    <input type="text" v-model="subject" class="form-control" id name="subject" placeholder="subject" aria-describedby="helpId">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-envelope text-call"></i></div>
                                    </div>
                                    <input type="number" v-model="number" class="form-control" id name="number" placeholder="0797656599"  aria-describedby="helpId">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-comment text-info"></i></div>
                                    </div>
                                    <textarea v-model="message" class="form-control" id name="message" placeholder="message" required aria-describedby="helpId"></textarea>
                                </div>
                            </div>

                           <button type="submit" class="btn btn-primary">Send</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return{
            name :'',
            email : '',
            subject : '',
            number : '',
            message : ''        }
    },
    methods: {
    addEmail(e) {
      e.preventDefault();
      let formData = new FormData();
      formData.append("name", this.name);
      formData.append("email", this.email);
      formData.append("subject", this.subject);
      formData.append("number", this.number);
      formData.append("message", this.message);
      axios
        .post("api/messages")
        .then(response => {
          this.name = "";
          this.email = "";
          this.subject = "";
          this.number = "";
          this.message = "";
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
}
</script>
<template>
  <div>
    <!-- Button trigger modal -->
    <button
      type="button"
      class="btn btn-success"
      data-toggle="modal"
      data-target="#exampleModal"
      @click="model()"
    >
      Add new Post
    </button>
    <div v-for="post in posts" :key="post.id">
      <h4>{{ post.title }}</h4>
      <p>{{ post.body }}</p>
      <button
        class="btn btn-primary"
        data-toggle="modal"
        data-target="#exampleModal"
        @click="editPost(post)"
      >
        edit
      </button>
      <button class="btn btn-danger" @click="deletePost(post.id)">
        delete
      </button>
    </div>

    <!-- Modal -->
    <div
      class="modal fade"
      id="exampleModal"
      tabindex="-1"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 v-if="edit" class="modal-title" id="exampleModalLabel">edit</h5>
            <h5 v-else class="modal-title" id="exampleModalLabel">Create</h5>

            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
              <div class="form-group">
                <label for="recipient-name" class="col-form-label"
                  >title:</label
                >
                <input
                  type="text"
                  class="form-control"
                  placeholder="title"
                  v-model="post.title"
                />
                <span v-if="errors.title" class="msg">{{
                  errors.title[0]
                }}</span>
              </div>

              <div class="form-group">
                <label for="message-text" class="col-form-label"
                  >description:</label
                >
                <textarea
                  class="form-control"
                  id="message-text"
                  v-model="post.body"
                ></textarea>

                <span v-if="errors.body" class="msg">{{ errors.body[0] }}</span>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button
              v-if="edit"
              type="button"
              class="btn btn-primary"
              @click="updatePost()"
            >
              edit
            </button>
            <button
              v-else
              type="button"
              class="btn btn-primary"
              @click="addPost()"
            >
              Save
            </button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">
              Close
            </button>
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
      post: {
        id: "",
        title: "",
        body: "",
      },
      edit: false,

      posts: {},
      errors: [],
    };
  },
  methods: {
    editPost(post) {
      (this.post = post), (this.edit = true);
    },
    updatePost() {
      let token = localStorage.getItem("token");

      axios
        .put("api/updatepost/" + this.post.id + "token=" + token, this.post)
        .then((response) => {
          this.edit = false;
          if (response.data.status == "error") {
            this.errors = response.data.errors;
            console.log(response.data.errors);
          } else if (response.data.status == "success") {
            Toast.fire({
              icon: "success",
              title: "Update successfully",
            });
            (this.errors = []),
              (this.post = {
                id: "",
                title: "",
                body: "",
              });
          }
        });
    },
    model() {
      (this.edit = false),
        (this.post = {
          id: "",
          title: "",
          body: "",
        });
    },
    deletePost(postid) {
      let token = localStorage.getItem("token");

      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
      }).then((result) => {
        if (result.isConfirmed) {
          axios
            .delete("api/deletepost/" + postid + "?token=" + token)
            .then((response) => {
              if (response.data.status == "success") {
                Swal.fire("Deleted!", "Your file has been deleted.", "success");
                this.getPost();
              }
            });
        }
      });
    },
    addPost() {
      this.edit = false;
      let token = localStorage.getItem("token");

      axios.post("api/createpost"+"?token="+token, this.post).then((response) => {
        if (response.data.status == "error") {
          this.errors = response.data.errors;
          console.log(response.data.errors);
        } else if (response.data.status == "success") {
          this.posts.unshift(response.data.data);
          Toast.fire({
            icon: "success",
            title: "success add new post",
          });
          (this.errors = []),
            (this.post = {
              id: "",
              title: "",
              body: "",
            });
        }
      });
    },
    getPost() {
      axios.get("api/getposts").then((response) => {
        this.posts = response.data.data;
      });
    },
  },
  created() {
    this.getPost();
  },
};
</script>

<style>
.msg {
  color: red;
}
</style>

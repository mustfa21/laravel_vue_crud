<template>
  <div>
          <span v-if="error" class="msg">errors</span>
    <input
      type="text"
      class="form-control m-1"
      placeholder="Enter Your Email"
      id=""
      v-model="user.email"
    />
    <input
      type="text"
      class="form-control m-1"
      placeholder="Enter Your Password"
      id=""
      v-model="user.password"
    />
    <button class="btn btn-primary m-1 btn-blok" @click="login()">login</button>
  </div>
</template>

<script>
export default {
  data() {
    return {
      user: {
        email: "",
        password: "",
      },
      error: false,
    };
  },
  methods: {
    login() {
      axios.post("api/login", this.user).then((response) => {
        if (response.data.status == "success") {
          let token = response.data.token;
          localStorage.setItem("token", token);
          this.error=false
        } else {
          this.error = true;
        }
      });
    },
  },
};
</script>

<style>
.msg{
    color: red;
}
</style>

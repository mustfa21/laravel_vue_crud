<template>
  <div>

<input type="text" class="form-control m-1" placeholder="Enter Your Name" id="" v-model="user.name">
<input type="text" class="form-control m-1" placeholder="Enter Your Email" id="" v-model="user.email">
<input type="text" class="form-control m-1" placeholder="Enter Your Password" id="" v-model="user.password">
<button class="btn btn-primary m-1 btn-blok" @click="register()"> Reigestar</button>

  </div>
</template>

<script>
export default {
data(){
    return{
        user:{
            name:'',
            email:'',
            password:''
        }
    }
},
methods:{
register(){
  axios
        .post("api/register",this.user )
        .then((response) =>{
   if (response.data.status == "error") {
            this.errors = response.data.errors;
            console.log(response.data.errors);
          } else if (response.data.status == "success") {
            Toast.fire({
              icon: "success",
              title: "successfully register done",
            });
          }
        })
}
}
}
</script>

<style>

</style>

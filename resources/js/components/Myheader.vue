<template>
  <div>
          <router-link to="/login" class="btn btn-primary m-1">login</router-link>
    <router-link to="/register" class="btn btn-primary m-1">register</router-link>
        <router-link to="/post" class="btn btn-primary m-1">post</router-link>
<button class="btn btn-primary m-1" @click="logout">Logout</button>
  <router-view></router-view>
  </div>
</template>

<script>
export default {
    methods:{
        logout(){
      let token = localStorage.getItem("token");
            axios.post('api/logout?token='+token).then((response) => {
                localStorage.removeItem;

            })
        }
    }

}
</script>

<style>

</style>

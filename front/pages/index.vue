<template>
  <div>
    index
  </div>
</template>

<script>
export default {
  auth:false,

  methods:{
    async sigIn ()
    {
      this.$auth.loginWith('laravelPassport',{
        data:{
          username:'example@gmail.com',
          password:'123456'
        }
      })
      .then(response=>{
        console.log(response);
      })
      .catch(error=>{
        console.error(error);
      });
    },

    async getUserInfo ()
    {
      this.$axios.get(process.env.BASE_URL+process.env.OAUTH_USER_INFO)
      .then(response=>{
        console.log(response);
      })
      .catch(error=>{
        console.error(error);
      });
    },

    logOut:function ()
    {
      this.$auth.logout();
    },
  }
}
</script>

<style>

</style>

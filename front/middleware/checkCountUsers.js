export default  async (context)=>{
  if (context.route.name!='admin-auth-registration') {
    return context.$axios.$post(process.env.BASE_URL + '/api/count-users')
      .then(response => {
        if (response.result == 0) {
          context.redirect({
            name: 'admin-auth-registration'
          });
        }
      })
      .catch(error => console.error(error));
  }
}

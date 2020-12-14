export default  async (context)=>{
  let response = await context.$axios.$post(process.env.BASE_URL + '/api/count-users').catch(error=>console.error(error));
  if (context.from.name=='admin-auth-registration' && response.result!=0) {
    context.redirect('/admin');
  }
}

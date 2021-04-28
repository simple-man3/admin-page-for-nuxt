export default (context,inject)=>{
  inject('pluginValidate',(qw)=>{
    console.log(context);
    context.$custom();
  })

  inject('custom',()=>{
    console.log('custom');
  })
}

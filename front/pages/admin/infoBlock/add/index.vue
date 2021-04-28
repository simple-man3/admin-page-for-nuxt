<template>
  <div>
    <save-edit-info-block
      :ar-t-field-prop="arTField"
      action-prop="save"
    />
  </div>
</template>

<script lang="ts">
import Vue from 'vue'
import saveEditInfoBlock from '/components/admin/infoBlock/saveEdit.vue'

type TField={
  [index:number]:number,
  id:number,
  name:string,
  active:boolean,
  created_at:Date,
  updated_at:Date
}[]

export default Vue.extend({
  layout:'admin/adminLayout',
  async asyncData ({$axios})
  {
    const data=await $axios.$get('/api/admin/info-block/get-type-fields')
      .then(response=>response.result)
      .catch(error=>console.error(error));

    return {
      arTField:data
    }
  },
  data:function ()
  {
    return{
      arTField:[] as TField,
    }
  },
  components:{
    'save-edit-info-block':saveEditInfoBlock
  },
  head:function ()
  {
    return{
      title:'Создание инфоблока'
    }
  }
})
</script>



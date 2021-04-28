<template>
  <!--
  <div class="wrapDetailInfoBlock">
    <div class="wrapErrorsComponent">
      <ListErrors
        :ar-errors-prop="errors"
        v-if="errors.length!=0"
      />
    </div>
    <Preloader v-if="display.preloader"/>
    <div class="wrapContentElement">
      <label for="active" :checked="infoBlockData.active">Активность:</label>
      <input type="checkbox" id="active" v-model="infoBlockData.active">
    </div>
    <div class="wrapContentElement">
      <p>
        Создано: {{infoBlockData.created_at}}
      </p>
    </div>
    <div class="wrapContentElement">
      <p>
        Создано пользователем: {{infoBlockData.user.name}}
      </p>
    </div>
    <div class="wrapContentElement contentInput">
      <AnimationInput
        title-prop="Название инфоблока"
        :input-data-prop="infoBlockData.name"
        @getInputValue="nameInfoBlock"
      />
    </div>
    <ListAdditionalFields
      :ar-additional-fields-prop="infoBlockData.additional_field"
      :ar-type-field-prop="arTypeField"
      :add-prop="false"
      @ListAdditionalFieldsAction="ListAdditionalFieldsAction"
    />
    <div class="wrapBtn">
      <div class="btnSave" @click="save">
        Сохранить
      </div>
    </div>
  </div>
  -->
  <div>
    <save-edit-info-block
      :ar-t-field-prop="arTypeField"
      action-prop="edit"
      :ar-t-info-block-data-prop="infoBlockData"
    />
  </div>
</template>

<script lang="ts">
import Vue from 'vue'
import saveEditInfoBlock from '/components/admin/infoBlock/saveEdit.vue'

type TInfoBlockData={
  id:number,
  name:string,
  active:boolean,
  user:object,
  additional_field:{
    [index:number]:number,
    id:number,
    active:boolean,
    created_at:Date,
    info_block_id:number,
    name:string,
    needFill:boolean,
    symbol_code:string,
    type_fields_id:number,
    updated_at:Date
  }[],
  created_at:Date,
  updated_at:Date
}
type TTypeField={
  [index:number]:number,
  id:number,
  name:string,
  active:boolean,
  created_at:Date,
  updated_at:Date
}[]
type TAsyncData={
  result:Object,
  arTypeField:{}[]
}

export default Vue.extend({
  layout:'admin/adminLayout',
  middleware:['auth'],
  async validate({params})
  {
    return /^\d+$/.test(params.id);
  },
  async asyncData({$axios,params})
  {
    const data:TAsyncData = await $axios.$post('/api/admin/info-block/get-current-info-block',{
      idInfoBlock:params.id
    }).catch(error=>console.error(error));

    // console.clear();
    // console.log(data['result']);

    if (data.result==null)
      throw({ statusCode: 404, message: 'This page could not be found'})
    else
      return {
        infoBlockData:Object.assign(data.result),
        arTypeField:data.arTypeField,
      }
  },
  data:function ()
  {
    return{
      infoBlockData:{} as TInfoBlockData,
      arTypeField:[] as TTypeField,
    }
  },
  components:{
    'save-edit-info-block':saveEditInfoBlock
  },
  head:function ()
  {
    let name:string=this.infoBlockData['name'];
    return{
      title:'Редактирование инфоблока: '+name
    }
  }
})
</script>

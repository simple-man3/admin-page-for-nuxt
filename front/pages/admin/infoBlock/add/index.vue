<template>
  <div class="wrapAdd">
    <Preloader v-if="display.preloader"/>
    <div>
      <AnimationInput
        title-prop="Название"
        :error-message-prop="error.name"
        @getInputValue="name"
      />
    </div>
    <div class="wrapBtn">
      <div @click="save" class="btnSave">
        Сохранить
      </div>
    </div>
  </div>
</template>

<script>
export default {
  layout:'admin/adminLayout',
  data:function ()
  {
    return{
      nameInfoBlock:'',
      error:{
        name:''
      },
      display:{
        preloader:false
      }
    }
  },
  methods:{
    async save ()
    {
      if (this.validate()) {
        this.display.preloader=true;

        this.$axios.post('/api/admin/info-block/create-info-block',{
          nameInfoBlock:this.nameInfoBlock
        })
        .then(response=>{
          this.$router.push({
            name:'admin-infoBlock'
          });
        })
        .catch(error=>{
          console.error(error);
        })
      }
    },

    validate:function ()
    {
      this.error.name='';

      if (this.nameInfoBlock=='') {
        this.error.name='Заполните название инфоблока';
        return false;
      }

      return true;
    },

    name:function (data)
    {
      this.nameInfoBlock=data.result;
    },
  },
  head:function ()
  {
    return{
      title:'Создание инфоблока'
    }
  }
}
</script>

<style scoped>
.wrapAdd{
  width: 20%;
  padding-top: 10px;
}

.wrapBtn{
  margin-top: 15px;
}

.wrapBtn .btnSave{
  width: 200px;
  background-color: #007bff;
  border-radius: 5px;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 38px;
  color: white;
  cursor: pointer;
}

.wrapBtn .btnSave{

}
</style>

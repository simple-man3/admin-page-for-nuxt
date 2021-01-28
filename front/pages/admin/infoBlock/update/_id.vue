<template>
  <div class="wrapDetailInfoBlock">
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
        :error-message-prop="errors.nameInfoBlock.msg"
        :display-error-prop="errors.nameInfoBlock.displayError"
        @getInputValue="nameInfoBlock"
      />
    </div>
    <div class="wrapBtn">
      <div class="btnSave" @click="save">
        Сохранить
      </div>
    </div>
  </div>
</template>

<script>
export default {
  layout:'admin/adminLayout',
  auth:true,
  async validate({params})
  {
    return /^\d+$/.test(params.id);
  },
  async asyncData({$axios,params})
  {
    const data = await $axios.$post('/api/admin/info-block/get-current-info-block',{
      idInfoBlock:params.id
    }).catch(error=>console.error(error));

    if (data.result==null)
      throw({ statusCode: 404, message: 'This page could not be found'})
    else
      return {
        infoBlockData:data.result
      }
  },
  data:function ()
  {
    return{
      infoBlockData:[],
      errors:{
        nameInfoBlock:{
          msg:'введите название инфоблока',
          displayError:false
        }
      },
      display:{
        preloader:false
      }
    }
  },
  methods:{
    async save ()
    {
      if (!this.validate()) {
        this.display.preloader=true;

        this.$axios.post('/api/admin/infoBlock/update',{
          arData:this.infoBlockData
        })
        .then(response=>{
          if (response) {
            this.$router.go(-1);
          }
        })
        .catch(error=>{
          console.error(error);
        })
      }
    },

    /**
     *  Валидация данных
     */
    validate:function ()
    {
      this.clearErrors();
      if (this.infoBlockData.name=='') {
        this.errors.nameInfoBlock.displayError=true
      }

      return this.checkErrors();
    },

    /**
     * Проверяет наличие ошибрк в объекте
     * @returns {boolean} - true => есть ошибки, false => нет ошибок
     */
    checkErrors:function ()
    {
      for (let arItem in this.errors) {
        if (this.errors[arItem].displayError) {
          return true;
        }
      }

      return false;
    },

    /**
     * Очищает все ошибки
     */
    clearErrors:function ()
    {
      for (let arItem in this.errors) {
        this.errors[arItem].displayError=false;
      }
    },

    /**
     * Получает данные из поля ввода компонента
     * @param data
     */
    nameInfoBlock:function (data)
    {
      this.infoBlockData.name=data.result;
    }
  }
}
</script>

<style scoped>
.wrapDetailInfoBlock{
  width: 400px;
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

.wrapContentElement{
  margin-bottom: 15px;
}

.contentInput{
  margin-top: 30px;
}
</style>

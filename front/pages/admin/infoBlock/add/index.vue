<template>
  <div class="wrapAdd">
    <div class="wrapErrorsComponent">
      <ListErrors
        :ar-errors-prop="error"
        v-if="error.length!=0"
      />
    </div>
    <Preloader v-if="display.preloader"/>
    <div>
      <AnimationInput
        title-prop="Название"
        :error-message-prop="error.name"
        @getInputValue="name"
      />
    </div>
    <ListAdditionalFields
      :ar-additional-fields-prop="arAdditionalFields"
      :ar-type-field-prop="arTypeField"
      @ListAdditionalFieldsAction="ListAdditionalFieldsAction"
    />
    <div class="wrapBtn">
      <div @click="save" class="btnSave">
        Сохранить
      </div>
    </div>
  </div>
</template>

<script>
import date from "~/plugins/date";
export default {
  layout:'admin/adminLayout',
  async asyncData ({$axios})
  {
    const data=await $axios.$get('/api/admin/info-block/get-type-fields')
      .then(response=>response.result)
      .catch(error=>console.error(error));

    return {
      arTypeField:data
    }
  },
  data:function ()
  {
    return{
      nameInfoBlock:'',
      error:[],
      display:{
        preloader:false
      },
      arTypeField:{},
      arAdditionalFields:[
        {
          name:'tetxe',
          symbolCode:'qwerty',
          needFill:false,
          typeField:1,
        },
        {
          name:'',
          symbolCode:'',
          needFill:false,
          typeField:1,
        },
        {
          name:'tetxe2',
          symbolCode:'qwerty',
          needFill:false,
          typeField:3,
        },
      ]
    }
  },
  methods:{
    async save ()
    {
      if (this.validate()) {
        this.display.preloader=true;
        this.$axios.post('/api/admin/info-block/create-info-block',{
          nameInfoBlock:this.nameInfoBlock,
          arAdditionalFields:this.filtrationAdditionalField(),
        })
        .then(response=>{
          console.log(response);

          this.$router.push({
            name:'admin-infoBlock'
          });
        })
        .catch(error=>console.error(error))
      }
    },

    /**
     * Валидирует данные
     * @return - true => если валидация прощла успешно, false => если валидация провалилась
     */
    validate:function ()
    {
      this.error=[];

      if (this.nameInfoBlock=='') {
        this.error.push('Введите название инфоблока');
      }

      let arResult=this.filtrationAdditionalField();
      this.checkUniqueSymbolCode(arResult);

      this.error=[...new Set(this.error)];

      return this.error.length==0?true:false;
    },

    name:function (data)
    {
      this.nameInfoBlock=data.result;
    },

    /**
     * Фильтрация массива дополнительных полей.
     * Из массива удаляются те массивы, где не было введено название поля
     * @returns []
     */
    filtrationAdditionalField:function ()
    {
      let arResult=[];
      this.arAdditionalFields.forEach((arItem,index)=>{
        if (arItem.name!='') {
          if (arItem.symbolCode.match(/^[a-zA-Z_ ]*$/)) {
            arResult.push(arItem);
          }
          else {
            this.error.push('Символьный код должен включать в себя англ. буквы');
          }
        }
      })

      return arResult;
    },

    /**
     * Проверяет уникальность символьного кода
     * @param arData
     * @returns {boolean} - true => если прошла проверка на уникальность, false => не прошло на уникальность
     */
    async checkUniqueSymbolCode(arData)
    {
      let arSymbolCode=[];

      // Проверяет уникальность символьного кода внутри самого массива
      for (let [index,arItem] of Object.entries(arData)) {

        arSymbolCode.push(arItem.symbolCode);

        for (let [key,item] of Object.entries(arData)) {
          if (index!=key) {
            if (arItem.symbolCode==item.symbolCode) {
              this.error.push(`Символьный код должен быть уникальем: ${item.symbolCode}`);
            }
          }
        }
      }

      let result= await this.$axios.post('/api/admin/info-block/check-unique-symbol-code',{
        arSymbolCode:arSymbolCode
      })
      .catch(error=>console.error(error))

      if (result.data.result.length>0) {
        result.data.result.forEach((arItem,index)=>{
          this.error.push(`Символьный код "${arItem}" уже существует`);
        })
        return false;
      }

      return true;
    },

    ListAdditionalFieldsAction:function (data)
    {
      this.arAdditionalFields=data.result;
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

.wrapErrorsComponent .wrapListErrors{
  margin-bottom: 25px;
}
</style>

<template>
  <div class="wrapAdd">
    <div class="wrapErrorsComponent">
      <list-errors
        :ar-errors-prop="error"
        v-if="display.listErrors"
      />
    </div>
    <preloader v-if="display.preloader"/>
    <div v-if="actionPropCheck" class="wrapContentElement">
      <label for="active" :checked="arTInfoBlockData.active">Активность:</label>
      <input type="checkbox" id="active" v-model="arTInfoBlockData.active">
    </div>
    <div v-if="actionPropCheck" class="wrapContentElement">
      <p>
        Создано: {{arTInfoBlockData.created_at}}
      </p>
    </div>
    <div v-if="actionPropCheck" class="wrapContentElement">
      <p>
        Создано пользователем: {{arTInfoBlockData.user.name}}
      </p>
    </div>
    <div :class="{
      'input':actionPropCheck
    }">
      <animation-input
        title-prop="Название"
        :error-message-prop="error.name"
        :input-data-prop="nameInfoBlock"
        @getInputValue="name"
      />
    </div>
    <list-additional-fields
      :ar-additional-fields-prop="arTInfoBlockData['additional_field']"
      :ar-type-field-prop="arTField"
      ref="ListAdditionalFields"
    />
    <div class="wrapBtn">
      <div @click="save" class="btnSave">
        Сохранить
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import Vue from 'vue'
import { AxiosResponse } from "axios";
import * as _ from "lodash";

import ListErrors from '/components/admin/formListErrors/ListErrors.vue'
import Preloader from '/components/admin/preloader.vue'
import ListAdditionalFields from '/components/admin/ListAdditionalFields.vue'
import AnimationInput from '/components/admin/input/AnimationInput.vue'

type TField={
  [index:number]:number,
  id:number,
  name:string,
  active:boolean,
  created_at:Date,
  updated_at:Date
}[]
type TAdditionalFields={
  [index:number]:number,
  name:string,
  active:boolean,
  symbol_code:string,
  old_symbol_code?:string,
  needFill:boolean,
  info_block_id?:number,
  type_fields_id:number,
  newAdditionalField?:boolean,
  created_at?:Date,
  updated_at?:Date
}[]
type TUnique={
  unique:boolean,
  arDuplicate:string[]
}
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
    old_symbol_code?:string,
    type_fields_id:number,
    updated_at:Date
  }[],
  created_at:Date,
  updated_at:Date
}
type TApiUrl={
  save:string,
  edit:string,
}

export default Vue.extend({
  name: "save-edit",
  props:{
    /**
     * Список типов полей
     */
    arTFieldProp:{
      type:Array,
      required:true
    },
    /**
     * Тип действия
     * save - форма добавления
     * edit - форма изменения
     */
    actionProp:{
      type:String,
      required:false,
      default:'save'
    },
    /**
     * Вся информация об инфоблоке
     */
    arTInfoBlockDataProp:{
      type:Object,
      required:false,
      default: function() {
        return {};
      },
    }
  },
  data:function ()
  {
    return{
      error:[] as string[],
      nameInfoBlock: Object.keys(this.arTInfoBlockDataProp).length>0? this.arTInfoBlockDataProp['name']:'',
      display:{
        preloader:false,
        listErrors:false
      },
      arAdditionalFields: [] as TAdditionalFields,
      arTField:this.arTFieldProp as TField,
      arTInfoBlockData: _.cloneDeep(this.arTInfoBlockDataProp) as TInfoBlockData,
      apiUrl:{
        save:'/api/admin/info-block/create-info-block',
        edit:'/api/admin/info-block/update'
      } as TApiUrl
    }
  },
  components:{
    'list-errors':ListErrors,
    'preloader':Preloader,
    'list-additional-fields':ListAdditionalFields,
    'animation-input':AnimationInput,
  },
  computed:{
    actionPropCheck:function ():boolean
    {
      return this.actionProp=='edit';
    },
  },
  methods:{
    async save ():Promise<void>
    {
      // Получает список дополнительных полей из компонента
      this.arAdditionalFields=(this.$refs['ListAdditionalFields'] as any)['arAdditionalFields'];
      this.display.preloader=true;
      this.display.listErrors=false;

      this.validate().then((result:boolean)=>{
        if (result) {

          let requestData=()=>{
            return this.actionProp=='edit'?{
              id:this.arTInfoBlockData['id'],
              name:this.nameInfoBlock,
              active:this.arTInfoBlockData['active']? 1:0,
              arAdditionalFields: this.actionProp=='edit'? this.updateArrayAdditionalFields():this.arAdditionalFields,
            }:{
              name:this.nameInfoBlock,
              arAdditionalFields:this.arAdditionalFields
            };
          };

          this.$axios.post<AxiosResponse>(
            this.actionPropCheck?this.apiUrl['edit']:this.apiUrl['save'],
            requestData()
          )
          .then((response:object)=>{
            this.$router.push({
              name:'admin-infoBlock'
            });
          })
          .catch((error:any)=>{
            console.error(error);

            this.display.preloader=false;
          })
        } else {
          this.display.listErrors=true;
          this.display.preloader=false;
        }
      });
    },

    /**
     * Валидирует данные
     * @return - true => если валидация прощла успешно, false => если валидация провалилась
     */
    async validate():Promise<boolean>
    {
      this.error=[];

      if (this.nameInfoBlock=='') {
        this.error.push('Введите название инфоблока');
      }

      // Убирает все ключи, где не было введено название поля
      this.arAdditionalFields=this.arAdditionalFields.filter(item=>item.name!='');

      // Проверяет на уникальность символьный код локально
      const unique:TUnique=Object.assign(this.checkUniqueSymbolCodeLocal());
      if (!unique['unique']){
        this.error.push('Символьный код повторяется: '+unique['arDuplicate'].join(', '));
      }

      // Проверяет на уникальность символьный код глобально
      await this.checkUniqueSymbolCodeGlobal().then((result:TUnique)=>{
        if (!result['unique']) {
          this.error.push('Символьный код уже существует: '+result['arDuplicate'].join(', '));
        }
      });

      return this.error.length==0;
    },

    updateArrayAdditionalFields:function ():object
    {
      let arResult:{
        newFields:{}[],
        existFields:{}[]
      }={
        newFields:[],
        existFields:[]
      };

      _.cloneDeep(this.arAdditionalFields).forEach((item)=>{
        delete item['old_symbol_code'];
        delete item['created_at'];
        delete item['updated_at'];
        delete item['info_block_id'];

        if (item['newAdditionalField']) {
          delete item['newAdditionalField'];
          arResult['newFields'].push(Object.assign(item));
        } else {
          delete item['newAdditionalField'];
          arResult['existFields'].push(Object.assign(item));
        }
      });

      return arResult;
    },

    name:function (data:{result:string}):void
    {
      this.nameInfoBlock=data.result;
    },

    /**
     *  Проверяет, был ли изменён символьный код существующего "дополнительного" поля ввода
     */
    checkOnEditExistSymbolCode:function ()
    {

    },

    /**
     * Проверяет новые символьные коды на уникальность
     * @returns {boolean,Array<string>}
     * unique => true => если прошла проверка на уникальность, false => не прошло на уникальность
     * arDuplicate => массив дублирующихся символьных кодов
     */
    checkUniqueSymbolCodeLocal:function() :object
    {
      let mapSymbolCode:string[]=this.arAdditionalFields.map(item=>item.symbol_code);
      let arDuplicate:string[]=[];

      this.arAdditionalFields.map(item=>item.symbol_code).forEach(item=>{
        if (arDuplicate.indexOf(item)==-1 && (mapSymbolCode.indexOf(item)!=mapSymbolCode.lastIndexOf(item))) {
          arDuplicate.push(item);
        }
      });

      return {
        'unique': arDuplicate.length==0,
        'arDuplicate':arDuplicate
      };
    },

    /**
     * Проверяет уникальность символьного кода глобально
     */
    async checkUniqueSymbolCodeGlobal () : Promise<TUnique>
    {
      let arSymbolCode:string[]=[];

      this.arAdditionalFields.forEach((item,key)=>{
        if (!item['newAdditionalField'] && item['old_symbol_code']!=item['symbol_code']) {
          arSymbolCode.push(item.symbol_code);
        } else if (item['newAdditionalField']) {
          arSymbolCode.push(item.symbol_code);
        }
      });

      const result:any = await this.$axios.post<AxiosResponse>('/api/admin/info-block/check-unique-symbol-code',{
        arSymbolCode:arSymbolCode
      })
      .catch((error:any)=>console.error(error))

      return result['data']['result'];
    },
  }
});
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

.wrapDetailInfoBlock{
  width: 100%;
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

.wrapErrorsComponent .wrapListErrors{
  margin-bottom: 25px;
}

.wrapContentElement input[type="checkbox"]{
  margin-left: 4px;
}

.input{
  margin-top: 23px;
}
</style>

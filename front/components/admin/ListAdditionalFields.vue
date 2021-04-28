<template>
  <div class="wrapListAdditionalFields">
    <Preloader v-if="display.preloader"/>
    <div class="wrapTitle">
      <p>
        Дополнительные поля
      </p>
    </div>
    <table class="tableAdditionalFields">
      <tr class="titleTable">
        <td class="wrapTdName">Название</td>
        <td class="wrapTdSymbolCode">Символьный код</td>
        <td class="wrapTdTypeField">Обяз.</td>
        <td class="wrapTdTypeField">Тип поля</td>
        <td></td>
      </tr>
      <tr v-for="(arItem,index) in arAdditionalFields" :key="index">
        <td>
          <input type="text" v-model="arAdditionalFields[index].name" >
        </td>
        <td>
          <input @keydown="validateInput($event,arAdditionalFields[index].symbol_code)" type="text" v-model="arAdditionalFields[index].symbol_code">
        </td>
        <td>
          <input
            type="checkbox"
            v-model="arAdditionalFields[index].needFill"
            :checked="arAdditionalFields[index].needFill"

          >
        </td>
        <td>
          <select v-model="arAdditionalFields[index].type_fields_id">
            <option
              v-for="(arItem,index) in arTypeField" :key="index"
              :value="arItem.id"
            >
              {{arItem.name}}
            </option>
          </select>
        </td>
        <td>
          <div class="btnDelete" @click="arItem.newAdditionalField? deleteNewRow(index):deleteExistField(arItem.id,index)">
            Удалить
          </div>
        </td>
      </tr>
    </table>
    <div class="wrapBtnAddNewRow">
      <div class="btnAddRow" @click="addRow">
        Добавить строку
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import Vue from 'vue'

type AdditionalFields={
  [index:number]:number
  id?:number,
  active:boolean,
  name:string,
  needFill:boolean,
  info_block_id?:number,
  newAdditionalField:boolean
  symbol_code:string,
  type_fields_id:number,
  created_at?:Date,
  updated_at?:Date
}[]
type TypeField={
  [index:number]:number
  id:number,
  name:string,
  active:boolean,
  created_at:Date,
  updated_at:Date
}[]

export default Vue.extend({
  name: "list-additional-fields",
  props:{
    arAdditionalFieldsProp:{
      type:Array,
      required:false,
      default:function ()
      {
        return []
      }
    },
    arTypeFieldProp:{
      type:Array,
      required: false,
      default:function ()
      {
        return [];
      }
    },
  },
  data:function ()
  {
    return {
      arAdditionalFields:this.arAdditionalFieldsProp as AdditionalFields,
      arTypeField:this.arTypeFieldProp as TypeField,
      display:{
        preloader:false
      }
    }
  },
  components:{
    Preloader:()=>import('@/components/admin/preloader/Preloader.vue')
  },
  created:function ()
  {
    console.clear();
    console.log(this.arTypeField);
    console.log(this.arTypeField[0]['name']);
    this.updateArAdditionalFields();
  },
  watch:{
    arAdditionalFieldsProp:function ()
    {
      this.arAdditionalFields=this.arAdditionalFieldsProp as AdditionalFields;
    },

    arTypeFieldProp:function ()
    {
      this.arTypeField=this.arTypeFieldProp as TypeField;
    },
  },
  methods:{
    /**
     * Валидация данных по следующим параметрам:
     * - должны быть только англ. буквы
     * - допустимый символ только "_"
     * - допустимы целочисленные цифры
     * - первым символом всегда должна быть буква
     */
    validateInput:function (e:any,data:string):void
    {
      let validWords:string = 'qwertyuiopasdfghjklzxcvbnm';
      let validateSymbol:string = '_';
      let validateNumbers:string = '1234567890';
      let validateSpecialBtn:number[] = [37,39,8];

      // Проверка, чтобы первый символ был только англ.буквой
      if (data.length==0 && validWords.indexOf((e.key).toLowerCase())==-1) {
        e.preventDefault();
        return;
      }

      if (
        validWords.indexOf((e.key).toLowerCase())==-1 &&
        validateNumbers.indexOf((e.key).toLowerCase())==-1 &&
        validateSpecialBtn.indexOf(e.keyCode)==-1 &&
        e.key!=validateSymbol
      ) {
        e.preventDefault();
      }
    },

    deleteNewRow:function (index:number):void
    {
      this.arAdditionalFields.splice(index,1);
    },

    /**
     * @param id => id дополнительного поля
     * @param index => индекс в массиве arAdditionalFields
     */
    async deleteExistField(id:number,index:number)
    {
      this.display.preloader=true;

      this.$axios.post('/api/admin/info-block/delete-current-field',{
          'idField':id
      })
      .then(response=>{
        console.log(response);
        this.arAdditionalFields.splice(index,1);
        this.display.preloader=false;
      })
      .catch(error=>console.error(error));
    },

    addRow:function () :void
    {
      this.arAdditionalFields.push({
        name:'',
        active:true,
        symbol_code:'',
        needFill:false,
        type_fields_id:this.arTypeField[0]['id'],
        newAdditionalField:true
      })
    },

    /**
     * Для существующих дополнительных полей ввода добавляется новый ключ, указывающий, что данное поле уже существует
     */
    updateArAdditionalFields:function ():void
    {
      this.arAdditionalFields.forEach((arItem,key)=>{
        this.$set(
          this.arAdditionalFields[key],
          'newAdditionalField',
          false
        );
      });
    },
  }
})
</script>

<style scoped>
.tableAdditionalFields{
  border-collapse: collapse;
  width: 100%;
}

.tableAdditionalFields .titleTable td{
  padding: 15px 0;
  text-align: center;
}

.tableAdditionalFields td{
  padding: 15px 15px 15px 0;
  border-bottom: 1px solid #cbcbcb;
}

.tableAdditionalFields tr:last-child td{
  border-bottom: none;
}

.wrapAdd .wrapTitle{
  padding: 20px 0;
  font-weight: 600;
  text-decoration: underline;
}

.tableAdditionalFields input,
.tableAdditionalFields select{
  width: 100%;
  border-radius: 5px;
  border: 1px solid;
  padding: 2px 5px;
  background-color: unset;
}

.tableAdditionalFields .btnDelete{
  cursor: pointer;
}

.wrapBtnAddNewRow{
  display: flex;
  justify-content: center;
  padding-top: 20px;
}

.wrapBtnAddNewRow .btnAddRow{
  width: 200px;
  background-color: #007bff;
  border-radius: 5px;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 38px;
  color: white;
  cursor: pointer;
  transition: .3s;
}

.wrapBtnAddNewRow .btnAddRow:hover{
  background-color: #093769;
}

.wrapListAdditionalFields input{

}
</style>

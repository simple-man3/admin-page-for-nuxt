<template>
  <div class="wrapListAdditionalFields">
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
          <input type="text" v-model="arAdditionalFields[index].symbolCode">
        </td>
        <td>
          <input
            type="checkbox"
            v-model="arAdditionalFields[index].needFill"
            :checked="arAdditionalFields[index].needFill"
          >
        </td>
        <td>
          <select v-model="arAdditionalFields[index].typeField">
            <option
              v-for="(arItem,index) in arTypeField" :key="index"
              :value="arItem.id"
            >
              {{arItem.name}}
            </option>
          </select>
        </td>
        <td>
          <div class="btnDelete" @click="deleteRow(index)">
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

<script>
export default {
  name: "ListAdditionalFields",
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
        return []
      }
    }
  },
  data:function ()
  {
    return {
      arAdditionalFields:this.arAdditionalFieldsProp,
      arTypeField:this.arTypeFieldProp
    }
  },
  watch:{
    arAdditionalFieldsProp:
    {
      handler:function ()
      {
        this.arAdditionalFields=this.arAdditionalFieldsProp;

        this.$emit('ListAdditionalFieldsAction', {
          result: this.arAdditionalFields
        });
      },
      deep:true
    },

    arTypeFieldProp:function ()
    {
      this.arTypeField=this.arTypeFieldProp;
    }
  },
  methods:{
    deleteRow:function (index)
    {
      this.arAdditionalFields.splice(index,1);
    },

    addRow:function ()
    {
      this.arAdditionalFields.push({
        name:'',
        symbolCode:'',
        needFill:false,
        typeField:this.arTypeField[0]['id'],
      })
    },
  }
}
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

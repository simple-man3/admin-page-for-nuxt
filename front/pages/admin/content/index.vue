<template>
  <div>
      <div class="wrapLeft"></div>
      <div class="wrapRight">
<!--        <nuxt-link :to="{name:'admin-infoBlock-add'}">-->
<!--          <div class="btnAdd">-->
<!--            Добавить инфоблок-->
<!--          </div>-->
<!--        </nuxt-link>-->
      </div>
<!--    <table :class="{'empty':isEmptyInfoBlock}">-->
    <table>
      <tr>
        <td class="wrapCheckBox">
<!--          <input :checked="mainCheckBox" type="checkbox" @click="checkAllCheckbox()">-->
          <input type="checkbox">
        </td>
        <td class="wrapTitleId">
          ID
        </td>
        <td class="wrapSingleBtn">
          btn
        </td>
        <td>
          Название
        </td>
        <td>
          Активно
        </td>
        <td>
          Создано
        </td>
      </tr>
<!--      <tr v-for="(arItem,index) in arInfoBlocks" :key="index">-->
<!--        <td>-->
<!--          <input type="checkbox" :checked="arItem.checked" v-model="arItem.checked">-->
<!--        </td>-->
<!--        <td>-->
<!--          {{arItem.id}}-->
<!--        </td>-->
<!--        <td>-->
<!--          btn-->
<!--        </td>-->
<!--        <td>-->
<!--          <nuxt-link class="linkInfoBlock" :to="{-->
<!--                name:'admin-infoBlock-update-id',-->
<!--                params:{-->
<!--                  id:arItem.id,-->
<!--                }-->
<!--            }">-->
<!--            {{arItem.name}}-->
<!--          </nuxt-link>-->
<!--        </td>-->
<!--        <td>-->
<!--          <p>-->
<!--            {{arItem.active?'Активно':'Не активно'}}-->
<!--          </p>-->
<!--        </td>-->
<!--        <td>-->
<!--          {{arItem.created_at}}-->
<!--        </td>-->
<!--      </tr>-->
    </table>
<!--    <div v-if="isEmptyInfoBlock" class="wrapEmpty">-->
<!--      Пусто-->
<!--    </div>-->
  </div>
</template>

<script lang="ts">
import Vue from 'vue'
export default Vue.extend({
  name: "index",
  auth:true,
  layout:'admin/adminLayout',
  data:function ()
  {
    return {
    }
  },
})
</script>

<style scoped>
.wrapTitleId,
.wrapCheckBox,
.wrapSingleBtn{
  width: 64px;
}

.wrapInfoBlocks a{
  text-decoration: none;
}

table{
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 20px;
}

table input[type='checkbox']{
  cursor: pointer;
}

table tr:last-child td{
  border: none;
}

table td{
  padding: 15px;
  border-bottom: 1px solid #cbcbcb
}

table .linkInfoBlock{
  text-decoration: none;
  color: #3490dc;
  transition: .3s;
}

table .linkInfoBlock:hover{
  color: #1d68a7;
}

.wrapInfoBlocks .wrapTopPanel{
  display: flex;
  flex-flow: wrap;
}

.wrapInfoBlocks .wrapTopPanel .wrapLeft{
  width: 50%;
}

.wrapInfoBlocks .wrapTopPanel .wrapRight{
  width: 50%;
  display: flex;
  justify-content: flex-end;
}

.btnAdd{
  width: 200px;
  background-color: #007bff;
  border-radius: 5px;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 38px;
  color: white;
}

.wrapInfoBlocks .wrapPagination{
  margin-top: 20px;
}

.wrapEmpty{
  display: flex;
  justify-content: center;
  align-items: center;
  background-color: #ececec;
  height: 50px;
  margin-bottom: 15px;
}

.empty{
  margin-bottom: 0!important;
}
</style>

<template>
  <div class="wrapInfoBlocks">
    <div class="wrapTopPanel">
      <div class="wrapLeft"></div>
      <div class="wrapRight">
        <nuxt-link :to="{name:'admin-infoBlock-add'}">
          <div class="btnAdd">
            Добавить инфоблок
          </div>
        </nuxt-link>
      </div>
    </div>
    <table :class="{'empty':isEmptyInfoBlock}">
      <tr>
        <td class="wrapCheckBox">
          <input :checked="mainCheckBox" type="checkbox" @click="checkAllCheckbox()">
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
      <tr v-for="(arItem,index) in arInfoBlocks" :key="index">
        <td>
          <input type="checkbox" :checked="arItem.checked" v-model="arItem.checked">
        </td>
        <td>
          {{arItem.id}}
        </td>
        <td>
          btn
        </td>
        <td>
          <nuxt-link class="linkInfoBlock" :to="{
                name:'admin-infoBlock-update-id',
                params:{
                  id:arItem.id,
                }
            }">
            {{arItem.name}}
          </nuxt-link>
        </td>
        <td>
          <p>
            {{arItem.active?'Активно':'Не активно'}}
          </p>
        </td>
        <td>
          {{arItem.created_at}}
        </td>
      </tr>
    </table>
    <div v-if="isEmptyInfoBlock" class="wrapEmpty">
      Пусто
    </div>
    <mass-action
      v-if="!isEmptyInfoBlock"
      @dataFromRequest="dataFromRequest"
      :ar-checked-prop="getAllCheckedCheckbox"
    />
    <pagination
      v-if="!isEmptyInfoBlock && checkCountPosts"
      :pagination-prop="arPagination"
      :offset-prop="5"
      @selectedPage="selectedPage"
    />
  </div>
</template>

<script lang="ts">
import Vue from 'vue'
import massAction from '/components/admin/MassAction.vue'
import pagination from '/components/admin/pagination/Pagination.vue'

type InfoBlocksType={
  [index:string]:any,
  id:number,
  name:string,
  active:boolean,
  checked:boolean,
  user_id:number,
  created_at:boolean,
  updated_at:boolean
}[]

export default Vue.extend({
  layout:'admin/adminLayout',
  auth:true,
  async validate({params})
  {
    return /^\d+$/.test(params.index);
  },
  async asyncData({$axios,params})
  {
    const countPost=20;
    const arInfoBlocks=await $axios.$post('/api/admin/info-block/get-all-info-block?page='+params.index,{
      usePaginate:true,
      count:countPost
    })
    .catch(error=>console.error(error));

    return {
      arInfoBlocks:arInfoBlocks.result.data,
      arPagination:arInfoBlocks.result,
    }
  },
  data:function ()
  {
    return{
      arInfoBlocks:[] as InfoBlocksType,
      checked:false,
      mainCheckBox:false,
      arPagination:{} as {[name:string]:any}
    }
  },
  components:{
    'mass-action':massAction,
    'pagination':pagination
  },
  computed:{
    getAllCheckedCheckbox:function ()
    {
      let arResult:number[]=[]

      this.arInfoBlocks.forEach((item,index)=>{
        if (this.arInfoBlocks[index]['checked']) {
          arResult.push(this.arInfoBlocks[index]['id']);
        }
      })

      return arResult;
    },

    isEmptyInfoBlock:function ():boolean
    {
      return this.arInfoBlocks.length<1;
    },

    checkCountPosts:function ():boolean
    {
      return this.arPagination['last_page']>1;
    }
  },
  created:function()
  {
    this.updateObjectFromDb();
  },
  methods:{
    /**
     * Выделить все checkBox
     */
    checkAllCheckbox:function ()
    {
      this.checked=!this.checked;
      this.mainCheckBox=!this.mainCheckBox;

      this.arInfoBlocks.forEach((item,key)=>{
        this.arInfoBlocks[key]['checked']=this.checked;
      })
    },

    /**
     * Очистить все checkBox
     */
    clearAllCheckbox:function ()
    {
      this.checked=this.mainCheckBox=false;

      this.arInfoBlocks.forEach((item,key)=>{
        this.arInfoBlocks[key]['checked']=this.checked;
      })
    },

    /**
     * Добавляет новый ключ 'checked'
     */
    updateObjectFromDb:function ()
    {
      this.arInfoBlocks.forEach((item,key)=>{
        this.$set(this.arInfoBlocks[key],'checked',false);
      })
    },

    /**
     * Callback из компонента MassAction
     * @param data => {arSelectedID:number[], action:string}
     */
    dataFromRequest:function (data:{arSelectedID:number[], action:string})
    {
      this.clearAllCheckbox();
      this.updateDateInfoBlocks(data);
    },

    /**
     * Изменения данные таблицы, после массового действия
     * @param data => {arSelectedID:number[], action:string}
     */
    updateDateInfoBlocks:function (data:{arSelectedID:number[], action:string})
    {
      data.arSelectedID.forEach((arItem,index)=>{
        this.arInfoBlocks.forEach((item,key)=>{
          if (arItem==item.id) {
            if (data.action=='active') {
              this.arInfoBlocks[key].active=true;
            }
            else if (data.action=='disable') {
              this.arInfoBlocks[key].active=false;
            }
            else if (data.action=='delete') {
              this.$delete(this.arInfoBlocks,key);
            }
          }
        })
      })
    },

    selectedPage:function (data:{result:number}) :void
    {
      this.$router.push({
        name:'admin-infoBlock-page',
        params:{
          index:data.result.toString()
        }
      });
    }
  }
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

.wrapInfoBlocks table{
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 20px;
}

.wrapInfoBlocks table input[type='checkbox']{
  cursor: pointer;
}

.wrapInfoBlocks table tr:last-child td{
  border: none;
}

.wrapInfoBlocks table td{
  padding: 15px;
  border-bottom: 1px solid #cbcbcb
}

.wrapInfoBlocks table .linkInfoBlock{
  text-decoration: none;
  color: #3490dc;
  transition: .3s;
}

.wrapInfoBlocks table .linkInfoBlock:hover{
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

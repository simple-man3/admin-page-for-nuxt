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
    <table>
      <tbody>
      <tr>
        <td class="wrapTitleId">
          ID
        </td>
        <td class="wrapCheckBox">
          <input :checked="mainCheckBox" type="checkbox" @click="checkAllCheckbox()">
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
          {{arItem.id}}
        </td>
        <td>
          <input type="checkbox" :checked="arItem.checked" v-model="arItem.checked">
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
      </tbody>
    </table>
    <MassAction
      @dataFromRequest="dataFromRequest"
      :ar-checked-prop="getAllCheckedCheckbox"
    />
    <Pagination
      :pagination-prop="arPagination"
      :offset-prop="5"
      @selectedPage="selectedPage"
    />
  </div>
</template>

<script>
export default {
  layout:'admin/adminLayout',
  auth:true,
  async validate({params})
  {
    return /^\d+$/.test(params.index);
  },
  async asyncData({$axios,params})
  {
    const arInfoBlocks=await $axios.$post('/api/admin/info-block/get-all-info-block?page='+params.index)
    .catch(error=>console.error(error));

    return {
      arInfoBlocks:arInfoBlocks.result.data,
      arPagination:arInfoBlocks.result,
    }
  },
  data:function ()
  {
    return{
      arInfoBlocks:{},
      checked:false,
      mainCheckBox:false,
      arPagination:{}
    }
  },
  computed:{
    getAllCheckedCheckbox:function ()
    {
      let arResult=[];

      for (let arItem in Object.keys(this.arInfoBlocks)) {
        if (this.arInfoBlocks[arItem]['checked']) {
          arResult.push(this.arInfoBlocks[arItem]['id']);
        }
      }

      return arResult;
    }
  },
  created:function()
  {
    this.updateObjectFromDb();
  },
  methods:{
    checkAllCheckbox:function ()
    {
      this.checked=!this.checked;
      this.mainCheckBox=!this.mainCheckBox;

      for (let arItem of Object.keys(this.arInfoBlocks)) {
        this.arInfoBlocks[arItem]['checked']=this.checked;
      }
    },

    clearAllCheckbox:function ()
    {
      this.checked=this.mainCheckBox=false;

      for (let arItem of Object.keys(this.arInfoBlocks)) {
        this.arInfoBlocks[arItem]['checked']=this.checked;
      }
    },

    updateObjectFromDb:function ()
    {
      for (let arItem of Object.keys(this.arInfoBlocks)) {
        this.$set(this.arInfoBlocks[arItem],'checked',false);
      }
    },

    dataFromRequest:function (data)
    {
      this.clearAllCheckbox();
      this.updateDateInfoBlocks(data);
    },

    updateDateInfoBlocks:function (data)
    {
      for (let [index,arItem] of Object.entries(data.arSelectedID)) {
        for (let [key,item] of Object.entries(this.arInfoBlocks)) {
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
        }
      }
    },

    selectedPage:function (data)
    {
      this.$router.push({
        name:'admin-infoBlock-page',
        params:{
          index:data.result
        }
      });
    }
  }
}
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
</style>

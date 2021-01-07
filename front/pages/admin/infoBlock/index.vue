<template>
  <div class="wrapInfoBlocks">
    <div class="wrapTopPanel">
      <div class="wrapLeft"></div>
      <div class="wrapRight">
        <nuxt-link to="#">
          <div class="btnAdd">
            knopka
          </div>
        </nuxt-link>
      </div>
    </div>
    <table>
      <tbody>
        <tr>
          <td>
            <input type="checkbox">
          </td>
          <td>
            btn
          </td>
          <td>
            ID
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
        <tr v-for="(arItem,index) in tyArray" :key="index">
          <td>
            <input type="checkbox">
          </td>
          <td>
            btn
          </td>
          <td>
            {{arItem.id}}
          </td>
          <td>
            <nuxt-link
              class="linkInfoBlock"
              to="#">
              {{arItem.name}}
            </nuxt-link>
          </td>
          <td>
            <p>
              {{arItem.active?'Активно':'Не активно'}}
            </p>
          </td>
          <td>
            {{arItem.date_create}}
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  name: "index",
  layout:'admin/adminLayout',
  data:function ()
  {
    return{
      tyArray:[
        {
          id:1,
          name:'инфоблок 1',
          active:true,
          date_create:'12.06.21',
        },
        {
          id:2,
          name:'инфоблок 2',
          active:false,
          date_create:'12.06.21',
        },
        {
          id:3,
          name:'инфоблок 3',
          active:true,
          date_create:'12.06.21',
        },
      ]
    }
  }
}
</script>

<style scoped>
.wrapInfoBlocks a{
  text-decoration: none;
}

.wrapInfoBlocks table{
  width: 100%;
  border-collapse: collapse;
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
</style>

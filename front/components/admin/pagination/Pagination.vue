<template>
  <div class="wrapPagination">
    <ul>
      <li
        v-for="(arItem,index) in pagination.arPages" :key="index"
        :class="{currentPage:arItem==pagination.current_page}"
        @click="selectedPage(arItem)"
      >
        <p>
          {{arItem}}
        </p>
      </li>
    </ul>
  </div>
</template>

<script lang="ts">
import Vue from 'vue'

type PaginationTypeProp={
  current_page: number,
  last_page: number,
  offset: number,
  arPages:number[],
}

export default Vue.extend({
  name: "Pagination",
  props:{
    paginationProp:{
      type:Object,
      default:()=>{}
    },
    offsetProp:{
      type:Number,
      required:false,
      default:1
    }
  },
  data:function ()
  {
    return{
      pagination:{} as PaginationTypeProp,
      offset:this.offsetProp
    }
  },
  created:function ()
  {
    this.createPaginateObject();
  },
  methods:{
    createPaginateObject:function ()
    {
        this.pagination['current_page']=this.paginationProp['current_page'];
        this.pagination['last_page']=this.paginationProp['last_page'];
        this.pagination['offset']=this.setOffset();
        this.pagination['arPages']=this.setPages();
    },

    /**
     * Устанавливает число пагинации вперёд.
     * Если текущая страница будет 12 из 14, то offset будет равен 2
     * Если текущая страница будет 14 из 14, то offset будет равен 0
     * @returns {number}
     */
    setOffset:function ()
    {
      if (this.paginationProp['current_page']+this.offset<=this.paginationProp['last_page']) {
        return this.offset;
      } else if (this.paginationProp['current_page']>this.paginationProp['last_page']) {
        return 0;
      } else {
        return this.paginationProp['last_page']-this.paginationProp['current_page'];
      }
    },

    setPages:function (): number[]
    {
      let arPages=[];
      let countPageForward=this.paginationProp['current_page']+this.pagination['offset'];

      if (this.paginationProp['current_page']==1) {
        for (let counter=1;counter<=countPageForward;counter++) {
          arPages.push(counter)
        }
      }
      else if (this.pagination['current_page'] <= this.pagination['last_page']) {
        /**
         * Определяем, сколько страниц до текущей страницы страницы
         * Например:
         *
         * currentPage = 6
         * offset = 4
         * 6 - 4 => 2
         * Значит надо начинать с 2-ой страницы
         */
        let counter=this.paginationProp['current_page']>this.offsetProp? this.pagination['current_page']-this.offset:1;

        for (counter;counter<=countPageForward;counter++) {
          arPages.push(counter);
        }
      }
      else {
        //ли находимся на последней странице
        let counter=this.pagination['last_page']-this.offset
        for (counter; counter<=this.pagination['last_page'];counter++) {
          arPages.push(counter)
        }
      }

      return arPages;
    },

    selectedPage:function (idPage: number) :void
    {
      this.$emit('selectedPage',{
        result:idPage
      })
    }
  }
})
</script>

<style scoped>
.wrapPagination ul{
  margin:0;
  padding:0;
  display: flex;
}

.wrapPagination ul li{
  list-style-type: none;
  cursor: pointer;
  background-color: #fafafa;
  padding: 6px 12px;
  border: 1px solid #ddd;
}

.wrapPagination ul li:hover{
  background-color: #ececec;
}

.wrapPagination ul li p{
  color: #666;
}

.currentPage{
  background-color: #337ab7!important;
}

.currentPage p{
  color: white!important;
}
</style>

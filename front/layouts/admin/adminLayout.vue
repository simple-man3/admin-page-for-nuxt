<template>
  <section>
    <NavbarAdminPage />
    <div id="adminPageSection">
      <div class="adminSideBar">
        <DeepMenuSidebar
          :ar-menu-links-prop="arMenuLinks"
        />
      </div>
      <div class="adminContent">
        <Nuxt />
      </div>
    </div>
  </section>
</template>

<script lang="ts">
import Vue from 'vue'
import auth from '@nuxtjs/auth-next'

type MenuLinksInterface={
  name:string, // название пункта меню
  route:string | null, // url пункта меню
  nameRoute:string | null, // название router
  beforeImgUrl:string | null, // путь до картикни для отображени перед названием меню
  afterImgUrl:string | null, // путь до картикни для отображени отображеня картинки после названием меню
  styleImg?:{ // различные стили для картинок
    beforeImg?:{ // стили для картинки отображаеюся перед название меню
      width:string | null, // ширина картинки. Пример: 25px
      height:string | null,// высота картинки. Пример: 25px
      transition:string | null, // время анимации. Пример: 1s
      hover?:{ // свойство при наведении на картинку
        imgUrl:string | null, // путь до новой картнки
        rotate:number | null, // угол поворота картинки. Пример: 25
      }
    },
    afterImg?:{ // стили для картинки отображаеюся перед название меню
      width:string | null, // ширина картинки. Пример: 25px
      height:string | null, // высота картинки. Пример: 25px
      transition:string | null, // время анимации. Пример: 1s
      hover:{ // свойство при наведении на картинку
        imgUrl:string | null, // путь до новой картнки
        rotate:number | null, // угол поворота картинки. Пример: 25
      }
    },
  },
  children?:MenuLinksInterface[] // меню уходящее в глубину
}[]

export default Vue.extend({
  data:function ()
  {
    return{
      arMenuLinks:[
        {
          name:'Главное',
          route:null,
          nameRoute:null,
          beforeImgUrl:'/img/admin/content.svg',
          afterImgUrl:'/img/admin/sort-down.svg',
          styleImg:{
            beforeImg:{
              width:'15px',
              height:'15px',
              hover:{
                imgUrl:'/img/admin/content-active.svg',
                rotate:null,
              }
            },
            afterImg:{
              width:'15px',
              height:'15px',
              transition:null,
              hover:{
                imgUrl:'/img/admin/content-active.svg',
                rotate:50,
              }
            },
          },
          children:[]
        },
        {
          name:'Контент',
          route:null,
          nameRoute:null,
          beforeImgUrl:'/img/admin/content.svg',
          afterImgUrl:'/img/admin/sort-down.svg',
          styleImg:{
            beforeImg:{
              width:'15px',
              height:'15px',
              hover:{
                imgUrl:'/img/admin/content-active.svg',
                rotate:null,
              }
            },
            afterImg:{
              width:'15px',
              height:'15px',
              transition:null,
              hover:{
                imgUrl:'/img/admin/content-active.svg',
                rotate:50,
              }
            },
          },
          children:[]
        },
        {
          name:'Инфоблоки',
          route:null,
          nameRoute:'admin-infoBlock',
          beforeImgUrl:'/img/admin/content.svg',
          afterImgUrl:'/img/admin/sort-down.svg',
          styleImg:{
            beforeImg:{
              width:'15px',
              height:'15px',
              transition:null,
              hover:{
                imgUrl:'/img/admin/content-active.svg',
                rotate:null,
              }
            },
            afterImg:{
              width:'15px',
              height:'15px',
              transition:null,
              hover:{
                imgUrl:'/img/admin/content-active.svg',
                rotate:null,
              }
            },
          },
          children:[]
        },
        {
          name:'Политика безопасности',
          route:null,
          nameRoute:null,
          beforeImgUrl:'/img/admin/content.svg',
          afterImgUrl:'/img/admin/sort-down.svg',
          styleImg:{
            beforeImg:{
              width:'15px',
              height:'15px',
              transition:null,
              hover:{
                imgUrl:'/img/admin/content-active.svg',
                rotate:null,
              }
            },
            afterImg:{
              width:'15px',
              height:'15px',
              transition:null,
              hover:{
                imgUrl:'/img/admin/content-active.svg',
                rotate:null,
              }
            },
          },
          children:[]
        },
        {
          name:'Настроки',
          route:null,
          nameRoute:null,
          beforeImgUrl:'/img/admin/content.svg',
          afterImgUrl:'/img/admin/sort-down.svg',
          styleImg:{
            beforeImg:{
              width:'15px',
              height:'15px',
              transition:'1s',
              hover:{
                imgUrl:'/img/admin/content-active.svg',
                rotate:null,
              }
            },
            afterImg:{
              width:'15px',
              height:'15px',
              transition:null,
              hover:{
                imgUrl:'/img/admin/content-active.svg',
                rotate:40,
              }
            },
          },
          children:[]
        }
      ],
    }
  },
  components:{
    DeepMenuSidebar:()=>import('@/components/admin/menu/DeepMenuSidebar.vue'),
    NavbarAdminPage:()=>import('@/components/admin/NavbarAdminPage.vue')
  }
})
</script>

<style>
/*.page-enter-active {*/
/*  animation: acrossIn .45s ease-out both;*/
/*}*/

/*.page-leave-active {*/
/*  animation: acrossOut .65s ease-in both;*/
/*}*/

/*@keyframes acrossIn {*/
/*  0% {*/
/*    !*transform: translate3d(-100%, 0, 0);*!*/
/*    !*transform: translateX(-100%);*!*/
/*    transform: rotate(360deg);*/
/*  }*/
/*  100% {*/
/*    !*transform: translate3d(0, 0, 0);*!*/
/*    !*transform: translateX(0);*!*/
/*    transform: rotate(0deg);*/
/*  }*/
/*}*/

/*@keyframes acrossOut {*/
/*  0% {*/
/*    transform: translate3d(0, 0, 0);*/
/*  }*/
/*  100% {*/
/*    transform: translate3d(0, -100%, 0);*/
/*  }*/
/*}*/

#adminPageSection{
  min-height: 95vh;
  min-width: 100%;
  background-color: #f5f5f5;
  display: flex;
}

#adminPageSection .adminSideBar{
  background-color: #333333;
  width: 300px;
  padding: 10px;
}

#adminPageSection .adminContent{
  overflow: hidden;
  width: calc(100% - 300px);
  margin: 15px;
  padding: 15px;
  background-color: white;
  border-radius: 5px;
  box-shadow: 0 0 34px -12px rgba(0,0,0,0.75);
}
</style>

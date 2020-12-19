<template>
  <ul class="wrapComponentMenu">
    <li v-for="(arItem,index) in arMenu" :key="index">
      <div class="wrapBtnSideMenu" @click="displayHiddenMenu(index)">
        <img
          v-if="arItem.beforeImgUrl!=null"
          class="imgBefore"
          :src="arItem.beforeImgUrl"
          :style="{
            height: arItem.sizeImg.height,
            width: arItem.sizeImg.width
          }"
          alt="img"
        >
        <img
          v-if="arItem.afterImgUrl!=null"
          class="imgAfter"
          :src="arItem.afterImgUrl"
          :style="{
            height: arItem.sizeImg.height,
            width: arItem.sizeImg.width
          }"
          alt="img"
        >
        <p
          v-if="arItem.route==null && arItem.nameRoute==null"
          :class="{selected:hiddenMenu.clicked && arItem.children.length}"
        >
          {{arItem.name}}
        </p>
        <nuxt-link
          v-else
          exact no-prefetch active-class="selected"
          :to="arItem.route==null? {name:arItem.nameRoute}:arItem.route"
        >
          {{arItem.name}}
        </nuxt-link>
      </div>
      <div
        class="wrapSubMenu"
        v-if="arItem.children && arItem.children.length"
        :style="{height:hiddenMenu[index].height+'px'}"
      >
        <div class="wrapInsideSubMenu" ref="blockCustom">
          <DeepMenuSidebar
            :ar-menu-links-prop="arItem.children"
            :is-child-prop="true"
            :parent-id-prop="index"
            @displayParent="displayParent"
            @closeParent="closeParent"
          />
        </div>
      </div>
    </li>
  </ul>
</template>

<script>
export default {
  name:'DeepMenuSidebar',
  props:{
    arMenuLinksProp:{
      type:Array,
      required:true,
      default: []
    },
    isChildProp:{
      type:Boolean,
      required: false,
      default:false
    },
    parentIdProp:{
      type:Number
    }
  },
  data:function ()
  {
    return{
      arMenu:this.arMenuLinksProp,
      isChild:this.isChildProp,

      hiddenMenu:[],
      display:{
        submenu:false
      },

      parentId:this.parentIdProp
    }
  },
  created:function(){
    this.setNewKey();
  },
  methods:{
    /**
     * Отображает дочерние компоненты
     * @index - индекс массива
     */
    displayHiddenMenu:function (index)
    {
      if (!this.hiddenMenu[index].clicked){
        //Если у нажатого элемента есть дочерние элементы
        if (this.arMenu[index].children.length) {
          // debugger
          this.arMenu;
          this.hiddenMenu[index].height=this.$refs['blockCustom'][index].clientHeight;
          this.hiddenMenu[index].clicked=true;

          // если блок сам дочерний элемент
          if (this.isChild) {
            this.$emit('displayParent',{
              height: this.$refs['blockCustom'][index].clientHeight,
              parentId:this.parentId
            })
          }
        }
      } else {
        // если блок сам дочерний элемент
        if (this.isChild) {
          this.$emit('closeParent',{
            height: this.$refs['blockCustom'][index].clientHeight,
            parentId:this.parentId
          })
        }

        this.hiddenMenu[index].height=0;
        this.hiddenMenu[index].clicked=false;
      }
    },

    /**
     * Рекурсивно изменяет высоту родительского блока
     */
    displayParent:function (data)
    {
      this.hiddenMenu[data.parentId].height=this.$refs['blockCustom'][data.parentId].clientHeight+data.height;

      this.$emit('displayParent',{
        parentId:this.parentId,
        height:data.height
      })
    },

    /**
     * Рекурсивно закрывает родительский компонент
     */
    closeParent:function (data)
    {
      this.hiddenMenu[data.parentId].height=this.$refs['blockCustom'][data.parentId].clientHeight-data.height;

      this.$emit('closeParent',{
        height: data.height,
        parentId:this.parentId
      });
    },

    setNewKey:function ()
    {
      for (let arItem in this.arMenu) {
        this.hiddenMenu.push({
          height:0,
          clicked:false
        })
      }
    },
  }
}
</script>

<style>
.wrapComponentMenu ul li{
  list-style-type: none;
}

.wrapComponentMenu ul li a{
  text-decoration: none;
  transition: .3s;
}

.wrapComponentMenu{
  overflow: hidden;
  cursor: pointer;
}

.wrapComponentMenu .wrapSubMenu{
  transition: .3s;
  overflow: hidden;
}

.wrapComponentMenu p{
  cursor: pointer;
  transition: .3s;
  color: #959595;
  margin-left: 30px;
}

.wrapComponentMenu a{
  color: #959595;
  transition: .3s;
}

.wrapComponentMenu .wrapBtnSideMenu:hover{
  color: white;
}

.selected{
  color: white!important;
}

.wrapComponentMenu .wrapInsideSubMenu .wrapComponentMenu{
  margin-left: 20px;
}

.wrapBtnSideMenu{
  position: relative;
  display: flex;
  margin: 5px 0;
}

.wrapComponentMenu .wrapBtnSideMenu .imgBefore{
  position: absolute;
  top: 5px;
}

.wrapComponentMenu .wrapBtnSideMenu .imgAfter{
  position: absolute;
  top: 5px;
  right: 5vw;
}

.wrapComponentMenu a{
  margin-left: 30px;
}

.wrapComponentMenu .wrapBtnSideMenu:hover p,
.wrapComponentMenu .wrapBtnSideMenu:hover a,
.wrapComponentMenu .wrapComponentMenu .wrapBtnSideMenu:hover a,
.wrapComponentMenu .wrapComponentMenu .wrapBtnSideMenu:hover p{
  color: white;
}
</style>

<!--Пример массива:
arMenuLinks:[
  {
    name:'Контент',
    route:null,
    nameRoute:null,
    beforeImgUrl:'/img/admin/landing-page.svg',
    afterImgUrl:'/img/admin/img.png',
    sizeImg:{
      width:'15px',
      height:'15px'
    },
    children:[
      {
        name:'Контент 2',
        route:null,
        nameRoute:null,
        beforeImgUrl:'/img/admin/landing-page.svg',
        afterImgUrl:'/img/admin/img.png',
        sizeImg:{
          width:'15px',
          height:'15px'
        },
        children:[]
      },
      {
        name:'Контент 3',
        route:null,
        nameRoute:null,
        beforeImgUrl:'/img/admin/landing-page.svg',
        afterImgUrl:'/img/admin/img.png',
        sizeImg:{
          width:'15px',
          height:'15px'
        },
        children:[]
      },
    ]
  },
],
-->

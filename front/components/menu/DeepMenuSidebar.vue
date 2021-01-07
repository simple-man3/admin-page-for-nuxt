<template>
  <ul class="wrapComponentMenu">
    <li v-for="(arItem,index) in arMenu" :key="index">
      <div
        class="wrapBtnSideMenu"
        @click="displayHiddenMenu(index)"
        @mouseover="activeHoverImg(index,arItem,'beforeImg')"
        @mouseleave="disableHoverImg(index,arItem,'beforeImg')"
      >
        <img
          v-if="arItem.beforeImgUrl!=null"
          class="imgBefore"
          :src="arItem.beforeImgUrl"
          :style="setCssImg('beforeImg',arItem)"
          alt="img"
          ref="beforeImg"
        >
        <img
          v-if="arItem.afterImgUrl!=null && Object.keys(arItem.children).length"
          class="imgAfter"
          :class="{openedImg:hiddenMenu[index].clicked}"
          :src="arItem.afterImgUrl"
          :style="setCssImg('afterImg',arItem)"
          alt="img"
          ref="afterImg"
        >
        <p
          v-if="(arItem.route==null && arItem.nameRoute==null) || arItem.children.length"
          :class="{
            selected:hiddenMenu[index].clicked,
          }"
          :style="{color:hiddenMenu.clicked? arItem.styleTitle.active.color:''}"
        >
          {{arItem.name}}
        </p>
        <nuxt-link
          v-else
          exact no-prefetch
          :to="arItem.route==null? {name:arItem.nameRoute}:arItem.route"
        >
          {{arItem.name}}
        </nuxt-link>
      </div>
      <div
        class="wrapSubMenu"
        v-if="arItem.children && Object.keys(arItem.children).length"
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

      parentId:this.parentIdProp,

      hoverCss:[
        {
          beforeImg:{
            transition:null,
            imgUrl:null,
            rotate:null,
          },
          afterImg:{
            transition:null,
            imgUrl:null,
            rotate:null,
          },
        },
      ],
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
      if (data.height!=null) {
        this.hiddenMenu[data.parentId].height = this.$refs['blockCustom'][data.parentId].clientHeight + data.height;
      } else {
        this.hiddenMenu[data.parentId].height=this.$refs['blockCustom'][data.parentId].clientHeight;
        this.hiddenMenu[data.parentId].clicked=true;
      }
      this.$emit('displayParent',{
        parentId:this.parentId,
        height:data.height!=null?data.height:null
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

    /**
     * Устанавливает свойство в тег img
     */
    setCssImg:function (beforeOrAfter,arResult)
    {
      return {
        width:arResult.styleImg[beforeOrAfter].width,
        height:arResult.styleImg[beforeOrAfter].height,
        transition:arResult.styleImg[beforeOrAfter].transition!=null && arResult.styleImg[beforeOrAfter].transition? arResult.styleImg[beforeOrAfter].transition:'',
      };
    },

    /**
     *
     * @param index - индекс ключа объекта
     * @param arResult - массив
     * @param beforeOrAfterImg
     */
    activeHoverImg:function (index, arResult, beforeOrAfterImg)
    {
      // Если вообще есть необходимые ключи и они не пустые
      if (
        (arResult.styleImg.beforeImg.hover && Object.keys(arResult.styleImg.beforeImg.hover).length) ||
        (arResult.styleImg.afterImg.hover && Object.keys(arResult.styleImg.afterImg.hover).length)
      ) {
        if (arResult.styleImg[beforeOrAfterImg].hover.imgUrl!=null) {
          this.$refs[beforeOrAfterImg][index].src=arResult.styleImg[beforeOrAfterImg].hover.imgUrl
        }
        if (arResult.styleImg[beforeOrAfterImg].hover.rotate!=null) {
          this.$refs[beforeOrAfterImg][index].style.transform=`rotate(${arResult.styleImg[beforeOrAfterImg].hover.rotate}deg)`;
        }
      }
    },

    disableHoverImg:function (index, arResult, beforeOrAfterImg)
    {
      this.$refs[beforeOrAfterImg][index].src=beforeOrAfterImg=='beforeImg'? arResult.beforeImgUrl:arResult.afterImgUrl;
      this.$refs[beforeOrAfterImg][index].style.transform='';
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
  text-decoration: none;
}

/*.selected{*/
/*  color: white!important;*/
/*}*/

.wrapComponentMenu .wrapInsideSubMenu .wrapComponentMenu{
  margin-left: 20px;
}

.wrapBtnSideMenu{
  position: relative;
  display: flex;
  margin: 5px 0;
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

.wrapComponentMenu .wrapBtnSideMenu .imgBefore{
  position: absolute;
  top: 6px;
}

.wrapComponentMenu .wrapBtnSideMenu .imgAfter{
  position: absolute;
  right: 5px;
  top: 6px;
  transition: .3s;
}

.openedImg{
  transform: rotate(-180deg);
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

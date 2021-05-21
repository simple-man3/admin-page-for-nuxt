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
          v-if="arItem.beforeImgUrl!==undefined"
          class="imgBefore"
          :src="arItem.beforeImgUrl"
          :style="setCssImg('beforeImg',arItem)"
          alt="img"
          :ref="'beforeImg_'+index"
        >
        <img
          v-if="arItem.afterImgUrl!=null && arItem.children!==undefined && Object.keys(arItem.children).length"
          class="imgAfter"
          :class="{openedImg:hiddenMenu[index].clicked}"
          :src="arItem.afterImgUrl"
          :style="setCssImg('afterImg',arItem)"
          alt="img"
          ref="afterImg"
        >
        <p
          v-if="isChildren(arItem) && ((arItem.route!==undefined && arItem.nameRoute!==undefined) || arItem.children.length)"
          :class="{
            selected:hiddenMenu[index].clicked,
          }"
          :style="{color:hiddenMenu.clicked? arItem.styleTitle.active.color:''}"
        >
          {{arItem.name}}
        </p>
        <p v-else-if="arItem.route===undefined && arItem.nameRoute===undefined">
          {{arItem.name}}
        </p>
        <nuxt-link
          v-else
          exact no-prefetch
          active-class="active"
          :to="{name:arItem.nameRoute}"
        >
          {{arItem.name}}
        </nuxt-link>
      </div>
<!--      <div-->
<!--        class="wrapSubMenu"-->
<!--        v-if="isChildren(arItem) && Object.keys(arItem.children).length"-->
<!--        :style="{height:hiddenMenu[index].height+'px'}"-->
<!--      >-->
<!--        <div class="wrapInsideSubMenu" ref="blockCustom">-->
<!--          <DeepMenuSidebar-->
<!--            :ar-menu-links-prop="arItem.children"-->
<!--            :is-child-prop="true"-->
<!--            :parent-id-prop="index"-->
<!--            @displayParent="displayParent"-->
<!--            @closeParent="closeParent"-->
<!--          />-->
<!--        </div>-->
<!--      </div>-->
    </li>
  </ul>
</template>

<script lang="ts">
import Vue from 'vue'

type TMenuLinks={
  [index:number]:number,
  id?:number | string, // ID меню
  name:string, // название пункта меню
  route:string | null, // url пункта меню
  nameRoute:string | null, // название router
  beforeImgUrl?:string | null, // путь до картикни для отображени перед названием меню
  afterImgUrl?:string | null, // путь до картикни для отображени отображеня картинки после названием меню
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
  children?:TMenuLinks // меню уходящее в глубину
}[]
type THiddenMenu={
  [name:string]:any,
  height:number,
  clicked:boolean
}[]

export default Vue.extend({
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
      arMenu:this.arMenuLinksProp as TMenuLinks,
      isChild:this.isChildProp,
      hiddenMenu:[] as THiddenMenu,
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
    displayHiddenMenu:function (index:number):void
    {
      if (!this.hiddenMenu[index].clicked && this.arMenu!==undefined){
        //Если у нажатого элемента есть дочерние элементы
        // if (this.arMenu[index].children!==undefined && this.arMenu[index].children.length) {
        if (this.arMenu[index].children!==undefined) {
          this.hiddenMenu[index].height=(this.$refs['blockCustom'] as any)[index].clientHeight;
          this.hiddenMenu[index].clicked=true;

          // если блок сам дочерний элемент
          if (this.isChild) {
            this.$emit('displayParent',{
              height: (this.$refs['blockCustom'] as any)[index].clientHeight,
              parentId:this.parentId
            })
          }
        }
      } else {
        // если блок сам дочерний элемент
        if (this.isChild) {
          this.$emit('closeParent',{
            height: (this.$refs['blockCustom'] as any)[index].clientHeight,
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
    displayParent:function (data:{[name:string]:any}):void
    {
      if (data.height!=null) {
        this.hiddenMenu[data.parentId].height = (this.$refs['blockCustom'] as any)[data.parentId].clientHeight + data.height;
      } else {
        this.hiddenMenu[data.parentId].height=(this.$refs['blockCustom'] as any)[data.parentId].clientHeight;
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
    closeParent:function (data:{[name:string]:any}):void
    {
      this.hiddenMenu[data.parentId].height=(this.$refs['blockCustom'] as any)[data.parentId].clientHeight-data.height;

      this.$emit('closeParent',{
        height: data.height,
        parentId:this.parentId
      });
    },

    setNewKey:function ():void
    {
      this.arMenu.forEach((item)=>{
        this.hiddenMenu.push({
          height:0,
          clicked:false
        })
      });
    },

    /**
     * Устанавливает свойство в тег img
     * @param beforeOrAfter => ключ объекта, находясь в объекте styleImg
     * @param arResult => объект
     */
    setCssImg:function (beforeOrAfter:string, arResult:{[name:string]:any}):{}
    {
      if (arResult['styleImg']!==undefined && arResult['styleImg'][beforeOrAfter]!==undefined) {
        return {
          width:arResult.styleImg[beforeOrAfter].width,
          height:arResult.styleImg[beforeOrAfter].height,
          transition:arResult.styleImg[beforeOrAfter].transition!=null && arResult.styleImg[beforeOrAfter].transition? arResult.styleImg[beforeOrAfter].transition:'',
        };
      } else {
        return {};
      }
    },

    /**
     *
     * @param index - индекс ключа объекта
     * @param arResult - массив
     * @param beforeOrAfterImg
     */
    activeHoverImg:function (index:number, arResult:{[name:string]:any}, beforeOrAfterImg:string):void
    {
      // Если вообще есть необходимые ключи и они не пустые
      if (arResult['beforeImgUrl']!==undefined && arResult['styleImg']!==undefined) {
        if (
          arResult['styleImg'][beforeOrAfterImg]!==undefined &&
          arResult['styleImg'][beforeOrAfterImg]['hover']!==undefined
        ) {
          (this.$refs[beforeOrAfterImg+'_'+index] as any)[0].src=arResult.styleImg[beforeOrAfterImg].hover.imgUrl
        }
        if (
          arResult.styleImg[beforeOrAfterImg].hover!==undefined &&
          arResult.styleImg[beforeOrAfterImg].hover.rotate!==undefined
        ) {
          (this.$refs[beforeOrAfterImg+'_'+index] as any)[0].style.transform=`rotate(${arResult.styleImg[beforeOrAfterImg].hover.rotate}deg)`;
        }
      }
    },

    disableHoverImg:function (index:number, arResult:{[name:string]:any}, beforeOrAfterImg:string):void
    {
      if (arResult['beforeImgUrl']!==undefined && arResult['styleImg']!==undefined) {
        (this.$refs[beforeOrAfterImg+'_'+index] as any)[0].src=arResult['beforeImgUrl'];
        (this.$refs[beforeOrAfterImg+'_'+index] as any)[0].style.transform=``;
      }
    },

    isChildren:function (arItem:{[name:string]:any}):boolean
    {
      return arItem['children']!==undefined;
    },
  }
})
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

.wrapComponentMenu li{
  margin-bottom: 15px;
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

.active{
  color: white!important;
}
</style>

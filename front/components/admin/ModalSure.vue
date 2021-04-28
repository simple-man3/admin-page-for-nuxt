<template>
  <div class="wrapModelSure" v-if="display.self">
    <div class="wrapModalWindow">
      <p>
        Вы уверены?
      </p>
      <div class="wrapBtns">
        <div class="btnYes">
          <div @click="sure">
            Да
          </div>
        </div>
        <div class="btnClose">
          <div @click="closeComponent">
            Закрыть
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import Vue from 'vue'

export default Vue.extend({
  name: "ModalSure",
  props:{
    displayComponentProp:{
      required:false,
      type:Boolean,
      default:false,
    }
  },
  data:function ()
  {
    return{
      display:{
        self:this.displayComponentProp
      }
    }
  },
  watch:{
    displayComponentProp:function ()
    {
      this.display.self=this.displayComponentProp;
    }
  },
  methods:{
    sure:function () :void
    {
      this.$emit('sure',true);
      this.display.self=false;
    },

    closeComponent:function () :void
    {
      this.$emit('notSure',false);

      this.display.self=false;
    }
  }
})
</script>

<style scoped>
.wrapModelSure{
  position: fixed;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
  display: flex;
  justify-content: center;
  align-items: center;
  background: rgba(0,0,0,.5);
  z-index: 100;
}

.wrapModelSure .wrapModalWindow{
  background-color: white;
  min-width: 300px;
  border-radius: 5px;
  padding: 10px;
}

.wrapModelSure .wrapModalWindow p{
  text-align: center;
  margin-bottom: 20px;
  font-size: 20px;
}

.wrapModelSure .wrapBtns{
  display: flex;
}

.wrapModelSure .wrapBtns .btnYes,
.wrapModelSure .wrapBtns .btnClose{
  width: 50%;
  display: flex;
}

.wrapModelSure .wrapBtns .btnClose{
  justify-content: flex-end;
}

.wrapModelSure .wrapBtns .btnYes>div{
  background-color: green;
  color: white;
  width: 120px;
  height: 30px;
  display: flex;
  justify-content: center;
  align-items: center;
  border-radius: 5px;
  cursor: pointer;
  transition: .3s;
}

.wrapModelSure .wrapBtns .btnYes>div:hover{
  background-color: #046704;
}

.wrapModelSure .wrapBtns .btnClose>div{
  background-color: #989a98;
  color: white;
  width: 120px;
  height: 30px;
  display: flex;
  justify-content: center;
  align-items: center;
  border-radius: 5px;
  cursor: pointer;
  transition: .3s;
}

.wrapModelSure .wrapBtns .btnClose>div:hover{
  background-color: #797979;
}
</style>

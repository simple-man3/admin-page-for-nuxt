<template>
  <div class="wrapMassAction">
    <Preloader v-if="display.preloader"/>
    <ModalSure
      :display-component-prop="display.sureModal"
      @sure="sure"
      @notSure="notSure"
    />
    <div class="wrapSelect">
      <select v-model="selectedAction">
        <option value="" selected> --ДЕЙСТВИЯ--</option>
        <option value="active">Активировать</option>
        <option value="disable">Деактивировать</option>
        <option value="delete">Удалить</option>
      </select>
    </div>
    <div class="wrapBtnAction">
      <div
        v-if="display.btn"
        class="btnAction"
        @click="doAction"
      >
        Выполнить
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "MassAction",
  props:{
    arCheckedProp:{}
  },
  data:function ()
  {
    return{
      selectedAction:'',
      display:{
        btn:false,
        sureModal:false,
        preloader:false
      },
      arChecked:this.arCheckedProp
    }
  },
  watch:{
    arCheckedProp:function ()
    {
      this.arChecked=this.arCheckedProp;
    },

    selectedAction:function ()
    {
      this.selectedAction!=''?this.display.btn=true:this.display.btn=false;
    },
  },
  methods:{
    doAction:function ()
    {
      this.display.sureModal = true;
    },

    async sure ()
    {
      if (this.arChecked.length!=0) {
        this.display.preloader=true;

        this.$axios.post('/api/admin/info-block/mass-action',{
          arSelected:this.arChecked,
          action:this.selectedAction
        })
        .then(response=>{
          this.$emit('dataFromRequest', {
            'arSelectedID': response.data.result,
            'action': this.selectedAction,
          })

          this.display.btn = this.display.sureModal = this.display.preloader = false;
          this.selectedAction='';
        })
        .catch(error=>console.error(error))
      }
    },

    notSure:function (data)
    {
      this.display.btn=this.display.sureModal=data;
      this.selectedAction='';
    }
  }
}
</script>

<style scoped>
.wrapMassAction{
  display: flex;
}

.wrapMassAction select{
  height: 35px;
  width: 145px;
}

.btnAction{
  width: 134px;
  background-color: #007bff;
  border-radius: 5px;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 35px;
  color: white;
  cursor: pointer;
}

.wrapSelect{
  margin-right: 35px;
}

.wrapBtnAction{

}
</style>

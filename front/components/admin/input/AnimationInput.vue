<template>
  <div class="wrapInputField">
    <div class="inputElements">
      <input
        v-model="inputValue"
        type="text"
        required
      >
      <p v-html="titleProp" />
    </div>
    <span v-if="error.displayError" v-html="error.errorMessage" class="error"/>
  </div>
</template>

<script>
export default {
  name: "AnimationInput",
  props:{
    titleProp:{
      required:true,
    },
    // Текст сообщения ошибки, если не заполнили
    errorMessageProp:{
      required:false,
      type:String,
      default:''
    },
    // Отображает ошибку заполнения
    displayErrorProp:{
      required: false,
      type:Boolean,
      default: false
    },
    // Контент внутри поля ввода
    inputDataProp:{
      required:false,
      default:''
    }
  },
  data:function ()
  {
    return{
      inputValue: this.inputDataProp,
      title:this.titleProp,
      error:{
        displayError:this.displayErrorProp,
        errorMessage: this.errorMessageProp,
      }
    }
  },
  watch: {
    inputValue: function () {
      this.$emit('getInputValue', {
        result: this.inputValue,
      });
    },

    errorMessageProp: function ()
    {
      this.error.errorMessage=this.errorMessageProp;
    },

    titleProp:function ()
    {
      this.title=this.titleProp;
    },

    displayErrorProp:function ()
    {
      this.error.displayError=this.displayErrorProp;
    },

    inputDataProp:function ()
    {
      this.inputValue=this.inputDataProp;
    }
  }
}
</script>

<style scoped>
.wrapInputField p{
  margin: 0;
  color: #919191;
  font-size: 14px;
  position: absolute;
  bottom: 5px;
  transition: .3s;
  pointer-events: none;
}

.wrapInputField input{
  width: 100%;
  height: 35px;
  border:none;
  border-bottom: 1px solid #ced4da;
  font-size: 20px;
}

.wrapInputField .inputElements{
  position: relative;
}

.wrapInputField .inputElements:before{
  content: '';
  position: absolute;
  bottom: 0;
  left: 0;
  height: 2px;
  width: 0;
  background-color: #3490dc;
  transition: .5s;
}

.wrapInputField .inputElements:focus-within::before{
  width: 100%;
}

.inputElements input:focus ~ p,
.inputElements input:valid ~ p{
  font-size: 10px;
  transform: translateY(-35px);
}

.wrapInputField .wrapInputField .error{
  color:red;
  font-size: 12px;
}

.wrapInputField .error{
  font-size: 12px;
  color: red;
}
</style>

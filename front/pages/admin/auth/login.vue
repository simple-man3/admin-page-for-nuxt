<template>
  <div class="loginPage">
    <preloader v-if="display.preloader"/>
    <div class="title">
      <p>
        Авторизация
      </p>
    </div>
    <div class="formAuth">
      <div class="wrapInputField">
        <div class="inputElements">
          <input
            v-model="arRegistration.login"
            type="text"
            required
          >
          <p>
            Логин
          </p>
        </div>
        <span
          v-html="Errors.login"
          class="error"
        ></span>
      </div>
      <div class="wrapInputField">
        <div class="inputElements">
          <input
            v-model="arRegistration.password"
            type="password"
            required
          >
          <p>
            Пароль
          </p>
        </div>
        <span
          v-html="Errors.password"
          class="error"
        ></span>
      </div>
      <div>
        <div @click="registration" class="registrationBtn">
          Регистрироваться
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "registration",
  layout:'admin/index',
  data:function ()
  {
    return{
      arRegistration:{
        login:'',
        password:'',
      },

      Errors: {
        login: '',
        password: '',
      },

      display:{
        preloader:false
      }
    }
  },
  watch:{
    arRegistration:
      {
        handler:function ()
        {
          // console.clear();
          // console.log(this.arRegistration);
        },
        deep:true
      }
  },
  methods:{
    async registration()
    {
    },

    clearMsgErrors:function ()
    {
      for(let arItem in this.Errors)
      {
        // console.log(arItem);
        this.Errors[arItem]='';
      }
    },

    validateData:function ()
    {
      this.clearMsgErrors();

      if (this.arRegistration.name=='')
      {
        this.Errors.name='Введите имя';
      }
    }
  },
}
</script>

<style>
.loginPage{
  display: block;
  width: 450px;
  height: 500px;
  margin: auto;
  padding-top: 20px;
}

.loginPage .title{
  background-color: #f7f7f7;
  width: 100%;
  height: 50px;
  display: flex;
  align-items: center;
  border-top-left-radius: 15px;
  border-top-right-radius: 15px;
  padding: 0 15px;
  border: 1px solid #e9e9e9;
}

.loginPage .title p{
  margin: 0;
}

.loginPage .formAuth{
  border: 1px solid #e9e9e9;
  width: 100%;
  background-color: white;
  padding: 20px 15px 15px;
}

.loginPage .title{
  font-size: 20px;
}

.formAuth .wrapInputField{
  margin-bottom: 30px;
}

.formAuth div:last-child{
  margin-bottom: 0;
}

.formAuth p{
  margin: 0;
  color: #919191;
  font-size: 14px;
  position: absolute;
  bottom: 5px;
  transition: .3s;
  pointer-events: none;
}

.formAuth input[type='text'],
.formAuth input[type='password']{
  width: 100%;
  height: 35px;
  border:none;
  border-bottom: 1px solid #ced4da;
  font-size: 20px;
}

.formAuth .registrationBtn{
  background-color: #3490dc;
  padding: 10px;
  border-radius: 5px;
  color: white;
  cursor: pointer;
  transition: .3s;
  width: 180px;
  display: flex;
  justify-content: center;
  align-items: center;
}

.formAuth .inputElements{
  position: relative;
}

.formAuth .inputElements:before{
  content: '';
  position: absolute;
  bottom: 0;
  left: 0;
  height: 2px;
  width: 0;
  background-color: #3490dc;
  transition: .5s;
}

.formAuth .inputElements:focus-within::before{
  width: 100%;
}

.inputElements input:focus ~ p,
.inputElements input:valid ~ p{
  font-size: 10px;
  transform: translateY(-35px);
}

.formAuth .wrapInputField .error{
  color:red;
  font-size: 12px;
}
</style>

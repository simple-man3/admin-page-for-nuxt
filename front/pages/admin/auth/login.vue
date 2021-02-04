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
            v-model="arDataAuth.login"
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
            v-model="arDataAuth.password"
            type="password"
            required
          >
          <p>
            Логин
          </p>
        </div>
        <span
          v-html="Errors.password"
          class="error"
        ></span>
      </div>
      <div>
        <div @click="sigin" class="registrationBtn">
          Войти
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  layout:'admin/auth',
  data:function ()
  {
    return{
      arDataAuth:{
        login:'user',
        password:'123456',
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
  methods:{
    async sigin()
    {
      if (this.validateData())
      {
        this.display.preloader=true;

        await this.$auth.loginWith('laravelPassport',{
          data:{
            username:this.arDataAuth.login,
            password:this.arDataAuth.password
          }
        })
        .catch(error=>{
          console.error(error);
          this.display.preloader=false;
        })
      }
    },

    clearMsgErrors:function ()
    {
      for(let arItem in this.Errors)
      {
        this.Errors[arItem]='';
      }
    },

    validateData:function ()
    {
      this.clearMsgErrors();

      this.arDataAuth.login==''?this.Errors.login='Введите логин':'';
      this.arDataAuth.password==''?this.Errors.password='Введите пароль':'';

      let checkErrors=()=>{
        for (let artItem in this.Errors){
          if (this.Errors[artItem]!='') return false;
        }

        return true;
      }

      return checkErrors();
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

.formAuth input{
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

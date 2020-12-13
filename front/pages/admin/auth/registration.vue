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
            v-model="arRegistration.email"
            type="text"
            required
          >
          <p>
            Почта
          </p>
        </div>
        <span
          v-html="Errors.email"
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
      <div class="wrapInputField">
        <div class="inputElements">
          <input
            v-model="arRegistration.confirmPassword"
            type="password"
            required
          >
          <p>
            Подтверждение пароля
          </p>
        </div>
        <span
          v-html="Errors.confirmPassword"
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
        login:'user',
        email:'example@gmail.com',
        password:'123456',
        confirmPassword:'123456'
      },

      Errors: {
        login: '',
        email: '',
        password: '',
        confirmPassword: ''
      },

      display:{
        preloader:false
      }
    }
  },
  methods:{
    async registration()
    {
      if (this.validateData()) {
        this.display.preloader=true;

        this.$axios.post(process.env.BASE_URL+'/api/registration-user',{
          login:this.arRegistration.login,
          email:this.arRegistration.email,
          password:this.arRegistration.password,
          confirmPassword:this.arRegistration.confirmPassword,
        })
        .then(response=>{
          this.$router.push({
            name:'admin-auth-login'
          });
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

      if (this.arRegistration.login!='') {
        let checkLatin=()=>{
          let regexp = /[а-яё]/i;

          return regexp.test(this.arRegistration.login)? 'введите только латинские буквы':'';
        };

        this.Errors.login=checkLatin();
      } else {
        this.Errors.login='введите логин';
      }

      if (this.arRegistration.email!='') {
        let validateEmail=()=>{
          const regularExpresion=/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

          return !regularExpresion.test(this.arRegistration.email)?'почта карочъ не валидна':'';
        }

        this.Errors.email=validateEmail();
      } else {
        this.Errors.email='введите почту';
      }

      if (this.arRegistration.password!='') {
        let checkLength=()=>this.arRegistration.password.length<6? 'минимальная длина пароль 6 букв':'';

        this.Errors.password=checkLength();
      } else {
        this.Errors.password='введите пароль';
      }

      if (this.arRegistration.confirmPassword!='') {
        this.Errors.confirmPassword=this.arRegistration.password!=this.arRegistration.confirmPassword? 'пароли не совпадают':'';
      } else {
        this.Errors.confirmPassword='повторите пароль';
      }

      let checkErrors=()=>{
        for (let arItem in this.Errors) {
          if (this.Errors[arItem]!='') return false;
        }
        return true;
      }

      return checkErrors();
    }
  }
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

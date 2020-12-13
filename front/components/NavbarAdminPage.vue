<template>
  <div v-if="displayComponent" class="containerComponentTop">
    <div class="leftPart">
      <ul>
        <li>
          <a href='#'>
            Админ панель
          </a>
        </li>
        <li>
          <a href="#">
            Сайт
          </a>
        </li>
      </ul>
    </div>
    <div class="rightPart">
      <ul>
        <li>
          <p>Привет, {{$auth.user.name}}</p>
        </li>
        <li>
          <p class="logOut" @click="logout">
            Выйти
          </p>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  name: "navbarAdminPage",
  computed:{
    displayComponent:function ()
    {
      return !this.$auth.user?false:true;
    }
  },
  methods:{
    async logout ()
    {
      this.$auth.logout();
    }
  }
}
</script>

<style>
.containerComponentTop{
  max-width: 100%;
  height: 50px;
  display: flex;
  align-items: center;
  padding: 0 15px;
  background-color: #ffffff;
  border-bottom: 1px solid #cacaca;
}

.containerComponentTop .leftPart{
  display: flex;
  width: 50%;
  padding-left: 25px;
}

.containerComponentTop .leftPart ul{
  margin: 0;
  padding: 0;
  display: flex;
}

.containerComponentTop .leftPart ul li{
  list-style-type: none;
}

.containerComponentTop .leftPart ul:first-child li{
  margin-right: 25px;
}

.containerComponentTop .leftPart ul li a{
  text-decoration: none;
  color: black;
  transition: .3s;
}

.containerComponentTop .leftPart ul li a:hover{
  color: #007bff;
}

.containerComponentTop .rightPart{
  width: 50%;
  display: flex;
  justify-content: flex-end;

}

.containerComponentTop .rightPart ul{
  margin: 0;
  padding: 0;
  display: flex;
}

.containerComponentTop .rightPart ul li{
  list-style-type: none;
}

.containerComponentTop .rightPart ul li p{
  margin: 0;
}

.containerComponentTop .rightPart ul li:first-child{
  margin-right: 25px;
}

.containerComponentTop .rightPart ul li .logOut{
  cursor: pointer;
  transition: .3s;
}

.containerComponentTop .rightPart ul li .logOut:hover{
  color: #007bff;
}
</style>

<template>
  <section>
<!--    <NavbarAdminPage />-->
    <div id="adminPageSection">
      <div class="adminSideBar">
        <DeepMenuSidebar
          :ar-menu-links-prop="arMenuLinks"
        />
      </div>
      <div class="adminContent">
        <Nuxt />
      </div>
    </div>
  </section>
</template>

<script>
import DeepMenuSidebar from '~/components/menu/DeepMenuSidebar'
// import NavbarAdminPage from '~/components/menu/DeepMenuSidebar'
export default {
  components:{
    DeepMenuSidebar,
  },
  data:function ()
  {
    return{
      arMenuLinks:[],
    }
  },
}
</script>

<style>
#adminPageSection{
  min-height: 95vh;
  min-width: 100%;
  background-color: #f5f5f5;
  display: flex;
}

#adminPageSection .adminSideBar{
  background-color: #333333;
  width: 300px;
  padding: 10px;
}

#adminPageSection .adminContent{
  width: calc(100% - 300px);
  padding: 10px;
}
</style>

<template>
  <section id="adminPageSection">
    <NavbarAdminPage />
    <Nuxt />
  </section>
</template>

<script>
export default {
name: "index"
}
</script>

<style>
#adminPageSection{
  min-height: 100vh;
  min-width: 100%;
  background-color: #f5f5f5;
}
</style>

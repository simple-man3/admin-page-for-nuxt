<template>
  <div class="wrapListErrors">
    <h1>
      Список ошибок:
    </h1>
    <ul>
      <li v-for="(arItem,index) in arErrors" :key="index">
        {{arItem}}
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  name: "ListErrors",
  props: {
    arErrorsProp: {
      type: Array,
      required: false,
      default: function () {
        return [];
      }
    }
  },
  data: function ()
  {
    return{
      arErrors:this.arErrorsProp
    }
  },
  created() {
    console.log(this.arErrors);
  },
  watch:{
    arErrorsProp:function ()
    {
      this.arErrors=this.arErrorsProp;
    }
  }
}
</script>

<style scoped>
.wrapListErrors{
  background-color: red;
  border-radius: 5px;
  padding: 15px;
}

.wrapListErrors ul{
  margin: 0;
  padding: 0;
}

.wrapListErrors ul li{
  color: white;
  list-style-type: none;
  font-weight: 600;
  position: relative;
  padding-left: 20px;
}

.wrapListErrors ul li:before{
  content: '';
  position: absolute;
  height: 2px;
  width: 10px;
  background-color: white;
  left: 5px;
  top: 13px;
}
</style>

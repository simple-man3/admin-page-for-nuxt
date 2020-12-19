<template>
  <li class="node-tree">
    <span class="label">{{ treeData.label }}</span>

    <ul v-if="treeData.children && treeData.children.length">
      <customComponent v-for="(child,index) in treeData.children" :tree-data="child" :key="index"/>
    </ul>
  </li>
</template>

<script>
export default {
  name: "customComponent",
  props: ['treeData'],
  data:function (){
    return{
      name:this.treeData.name
    }
  },
  mounted:function () {
    // console.log(this.treeData);
  },
  methods:{
  }
}
</script>

<style scoped>
ul{
  padding-left: 50px;
}
</style>

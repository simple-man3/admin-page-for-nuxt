<template>
  <div>
    <h1>
      content admin
    </h1>
    <div>
      <ul>
<!--        <customComponent :tree-data="tree"/>-->
      </ul>
    </div>
  </div>
</template>

<script>
import customComponent from "@/components/customComponent";
export default {
  name: "index",
  auth:true,
  layout:'admin/adminLayout',
  data:function ()
  {
    return{
      tree:
      {
        label: "A cool folder1",
        children: [
          {
            label: "A cool sub-folder 2",
            children: [
              {
                label: "A cool sub-sub-folder 3",
                children: [
                  {
                    label: "A cool sub-sub-folder 4",
                    children:[
                      {
                        label: "A cool sub-sub-folder 5",
                        children:[

                        ]
                      }
                    ]
                  },
                ]
              },
            ]
          },
        ]
      },
    }
  },
  components: {
    customComponent
  }
}
</script>

<style scoped>

</style>

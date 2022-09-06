<template>
  <section class="homepage-content grid gap-4 mt-10">
    <section class="border rounded-xl shadow-md shadow-gray-400 px-5">
      <p class="flex my-8 items-center">
        <img src="/images/trolley.png" alt="" />
        <b class="mx-2 text-lg">Đơn hàng mới: </b>
        <span class="text-lg font-semibold text-gray-500">3 đơn</span>
      </p>

      <table class="w-full">
        <thead>
          <tr class="bg-gray-100 h-12">
            <th class="w-1/3 text-left pl-20">Đơn hàng</th>
            <th class="w-1/3 text-left pl-20">Mã đơn</th>
            <th class="w-1/3 text-left pl-20">Trạng thái</th>
          </tr>
        </thead>
        <tbody>
          <tr class="border-b border-gray-300">
            <td class="py-4 flex items-center pl-20 mt-1">
              <img src="/images/product-demo.png" class="max-h-16" alt="" />
              <a href="" class="mx-2 underline">2022春夏新...</a>
              <span>x1</span>
            </td>
            <td class=" w-1/3 pl-20">MD001</td>
            <td class="w-1/3 pl-20">Chờ xác nhận</td>
          </tr>
          
          <tr class="w-full h-16 border-b border-gray-300">
            <td class="py-4 flex items-center pl-20 mt-1">
              <img src="/images/product-demo.png" class="max-h-16" alt="" />
              <a href="" class="mx-2 underline">2022春夏新...</a>
              <span>x1</span>
            </td>
            <td class="w-1/3 pl-20">MD001</td>
            <td class="w-1/3 pl-20">Chờ xác nhận</td>
          </tr>

          <tr class="w-full h-16 border-b border-gray-300">
            <td class="py-4 flex items-center pl-20 mt-1">
              <img src="/images/product-demo.png" class="max-h-16" alt="" />
              <a href="" class="mx-2 underline">2022春夏新...</a>
              <span>x1</span>
            </td>
            <td class="w-1/3 pl-20">MD001</td>
            <td class="w-1/3 pl-20">Chờ xác nhận</td>
          </tr>
        </tbody>
      </table>
    </section>

    <section class="border rounded-xl shadow-md shadow-gray-400">
      <p class="flex justify-center items-center my-8">
        <img src="/images/payper-send.png" alt="" class="mx-2" />
        <b class="mx-2 text-lg">Hoạt động mới</b>
      </p>
    </section>
  </section>
</template>

<script>
import axios from 'axios'
export default {
  data(){
    return {

    }
  },

  methods: {
    getAll(){
      axios.get('getUser').then(res => {
        console.log(res.data)
      })
    }
  },

  mounted() {
    this.getAll()
  }
  
};
</script>


<style scoped>
.homepage-content {
  grid-template-columns: 2fr 1fr;
}
</style>
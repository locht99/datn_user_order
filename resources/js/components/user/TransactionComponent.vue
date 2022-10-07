<template>
  <section style="height: 568px; max-height: 568px" class="border rounded-xl shadow-md shadow-gray-400 px-5 mt-10">
    <p class="flex my-8 items-center">
      <i class="fa-solid fa-money-bill-transfer text-2xl text-red-500"></i>
      <span class="mx-4 text-lg font-bold">Giao dịch</span>
    </p>

    <table class="w-full">
      <thead>
        <tr class="bg-gray-100">
          <th>STT</th>
          <th>Mã đơn hàng</th>
          <th>Loại giao dịch</th>
          <th>Nội dung</th>
          <th>Tiền giao dịch</th>
          <th>Thời gian</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in this.dataTrans" :key="index" class="border-b border-gray-300 text-center h-12">
          <td>{{index + 1}}</td>
          <td>{{item.order_id}}</td>
          <td>{{item.type_id}}</td>
          <td>{{item.content}}</td>
          <td>{{item.point_transaction}}</td>
          <td>{{item.create_at}}</td>
        </tr>

      </tbody>
    </table>
  </section>
</template>

<script>
import axios from "axios";
export default {
  data() {
    return { dataTrans: [] };
  },

  methods: {
    getDataTrans() {
      axios.get("api/transaction/get-transaction").then((res) => {
        this.dataTrans = res.data;
        console.log(res);
      });
    },
  },

  mounted() {
    this.dataTrans();
  },
};
</script>

<style scoped>

</style>

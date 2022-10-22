<template>
  <section
    style="height: 568px; max-height: 568px"
    class="border rounded-xl shadow-md shadow-gray-400 px-5 mt-10 relative"
  >
    <loading v-model:active="is_loading" :is-full-page="false" />
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
        <tr
          v-for="(transaction, index) in listTransaction"
          :key="index"
          class="border-b border-gray-300 text-center h-12"
        >
          <td>{{ ++index }}</td>
          <td>{{ transaction.order_id }}</td>
          <td>{{ transaction.type_name }}</td>
          <td>{{ transaction.content }}</td>
          <td>{{ formatPrice(transaction.point) }}</td>
          <td>{{ transaction.created_at }}</td>
        </tr>
      </tbody>
    </table>

    <Pagination
      v-if="dataPagination.last_page > 1"
      :pagination="dataPagination"
      :offset="5"
      @pagination-change-page="getTransactionByUser"
    ></Pagination>

  </section>
</template>

<script>
import { getTransaction } from "../../config/transaction";
import loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
export default {
  components: {
    loading,
  },
  data() {
    return {
      is_loading: false,
      listTransaction: [],
      dataPagination: {},
      lazyLoad: false,
    };
  },
  mounted() {
    this.getTransactionByUser();
  },
  methods: {
    formatPrice(value) {
      return new Intl.NumberFormat("en-US", {
        style: "currency",
        currency: "VND",
      }).format(value);
    },

    getTransactionByUser(page = 1) {
      this.is_loading = true;
      getTransaction(page)
        .then((res) => {
          this.dataPagination = res.data;
          this.listTransaction = this.dataPagination.data;
          this.perPage = this.dataPagination.per_page;
          this.total = this.dataPagination.total;
        })
        .catch((error) => {
          this.is_loading = false;
        })
        .finally(() => {
          this.is_loading = false;
        });
    },

    pageChange(pageNumber) {
      this.currentPage = pageNumber;
      this.getTransactionByUser();
    },
  },
};
</script>

<style scoped>
.min-w-max.pagination div {
  display: none !important;
  background: yellow;
}
</style>

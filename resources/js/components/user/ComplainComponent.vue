<template>
    <section class=" border rounded-xl shadow-md shadow-gray-400 my-5 py-10 px-5">
  <loading v-model:active="is_loading" :is-full-page="false" />

      <section class="w-auto">
        <p class="flex items-center">
          <i class="fa-solid fa-list-check text-2xl"></i>
          <span class="mx-2 text-lg font-semibold">Danh sách khiếu nại</span>
        </p>
  
        <ul class="my-3">
          <li class="my-3 flex">
            <div class="mr-5">
                <label class="font-semibold">Chọn đơn hàng*</label>
                <select name="type-payment"
                    class="w-full h-10 rounded-md border border-[#e0e0e0] bg-white px-6 font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md">
                    <option >Chọn đơn hàng</option>
                </select>
            </div>
            <div class="mr-5">
                <label class="font-semibold">Trạng thái khiếu nại*</label>
                <select name="type-payment" class="w-full h-10 rounded-md border border-[#e0e0e0] bg-white px-6 font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md">
                    <option value="0">Chọn trạng thái khiếu nại</option>
                    <option value="1">Khiếu nại thiếu hàng</option>
                    <option value="2">Khiếu nại sai mẫu - Bồi thường</option>
                </select>
            </div>
          </li>
          <li class="my-3">
              <label for="" class="font-semibold">Nội dung khiếu nại*</label>
              <textarea name="" id="" class="block w-full rounded mt-1 border-2 border-gray-300 resize-none h-28" placeholder="Nội dung chi tiết khiếu nại..."></textarea>
          </li>
        </ul>
        <button class="border py-2 px-5 bg-red-500 text-white rounded font-bold">Tạo đơn khiếu nại</button>
        <div class="h-[230px] overflow-y-auto">
            <table class="w-full mt-5">
        <thead>
          <tr class="bg-gray-100">
            <th>STT</th>
            <th>Mã đơn hàng</th>
            <th>Trạng thái khiếu nại</th>
            <th>Nội dung khiếu nại</th>
            <th>Nội dung phản hồi</th>
            <th>Tiền bồi thường</th>
            <th>Thời gian</th>
          </tr>
        </thead>
        <tbody>
          
        </tbody>
      </table>
        </div>
      </section>
    </section>
  </template>
  
  <script>
  import loading from "vue-loading-overlay";
  import "vue-loading-overlay/dist/vue-loading.css";
  import { getComplain } from "../../config/complain";
  export default {
    watch: {
          $route: {
              immediate: true,
              handler(to, from) {
                  document.title ='Khiếu nại đơn hàng';
              }
          },
    },
    components: {
      loading,
    },
    data() {
      return {
        is_loading: false,
        lazyLoad: false,
      };
    },
    mounted() {
        this.getComplainUser();
    },
    methods: {
      formatPrice(value) {
        return new Intl.NumberFormat("en-US", {
            style: "currency",
            currency: "VND",
        }).format(value);
      },
      getComplainUser(){
        this.is_loading = true;
        getComplain()
          .then((res) => {

          })
          .catch((error) => {
              this.is_loading = false;
          })
          .finally(() => {
              this.is_loading = false;
          });
      },
    }
  };
  </script>
  
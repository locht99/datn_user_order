<template>
  <section
    style="height: 590px; max-height: 590px"
    class="flex rounded-xl w-full border my-10 shadow-md shadow-gray-400"
  >
    <section class="w-1/4 border-r-2 px-8 py-5">
      <div class="sticky border-b-2 pb-4 pt-2">
        <i class="fa-solid fa-filter text-2xl text-gray-700 mr-5"></i>
        <span class="text-xl font-bold">Bộ lọc</span>
      </div>
      <div style="max-height: 435px" class="overflow-auto">
        <ul class="pt-3 pb-5">
          <li class="flex items-center text-xl">
            <i class="fa-solid fa-caret-right cursor-pointer"></i>
            <h3 class="ml-2">Theo website</h3>
          </li>
          <li class="flex items-center text-lg my-2">
            <input
              type="checkbox"
              name=""
              id="1688"
              class="rounded-md ml-4 focus:ring-0 cursor-pointer"
            />
            <label for="1688" class="cursor-pointer pl-2 select-none">1688.com</label>
          </li>
          <li class="flex items-center text-lg my-2">
            <input
              type="checkbox"
              name=""
              id="tmall"
              class="rounded-md ml-4 focus:ring-0 cursor-pointer"
            />
            <label for="tmall" class="cursor-pointer pl-2 select-none">tmall.com</label>
          </li>
          <li class="flex items-center text-lg my-2">
            <input
              type="checkbox"
              name=""
              id="taobao"
              class="rounded-md ml-4 focus:ring-0 cursor-pointer"
            />
            <label for="taobao" class="cursor-pointer pl-2 select-none">taobao.com</label>
          </li>
        </ul>

        <ul class="pt-3 pb-5">
          <li class="flex items-center text-xl">
            <i class="fa-solid fa-caret-right cursor-pointer"></i>
            <h3 class="ml-2">Theo trạng thái</h3>
          </li>
          <li class="flex items-center text-lg my-2">
            <input
              type="checkbox"
              name=""
              id="all"
              class="rounded-md ml-4 focus:ring-0 cursor-pointer"
            />
            <label for="all" class="cursor-pointer pl-2 select-none">Tất cả</label>
          </li>
          <li class="flex items-center text-lg my-2">
            <input
              type="checkbox"
              name=""
              id="deposit"
              class="rounded-md ml-4 focus:ring-0 cursor-pointer"
            />
            <label for="deposit" class="cursor-pointer pl-2 select-none">Đã đặt cọc</label>
          </li>
          <li class="flex items-center text-lg my-2">
            <input
              type="checkbox"
              name=""
              id="is_active"
              class="rounded-md ml-4 focus:ring-0 cursor-pointer"
            />
             <label for="is_active" class="cursor-pointer pl-2 select-none">Đang hoạt động</label>
          </li>

          <li class="flex items-center text-lg my-2">
            <input
              type="checkbox"
              name=""
              id="delivering"
              class="rounded-md ml-4 focus:ring-0 cursor-pointer"
            />
            <label for="delivering" class="cursor-pointer pl-2 select-none">Đang giao hàng</label>
          </li>

          <li class="flex items-center text-lg my-2">
            <input
              type="checkbox"
              name=""
              id="out_of_stock"
              class="rounded-md ml-4 focus:ring-0 cursor-pointer"
            />
            <label for="out_of_stock" class="cursor-pointer pl-2 select-none">Hết hàng</label>
          </li>

          <li class="flex items-center text-lg my-2">
            <input
              type="checkbox"
              name=""
              id="canceled"
              class="rounded-md ml-4 focus:ring-0 cursor-pointer"
            />
            <label for="canceled" class="cursor-pointer pl-2 select-none">Hủy bỏ</label>
          </li>

          <li class="flex items-center text-lg my-2">
            <input
              type="checkbox"
              name=""
              id="lost"
              class="rounded-md ml-4 focus:ring-0 cursor-pointer"
            />
            <label for="lost" class="cursor-pointer pl-2 select-none">Thất lạc</label>
          </li>
        </ul>

         <!-- Theo trạng thái -->
        <ul class="pt-3 pb-5">
          <li class="flex items-center text-xl">
            <i class="fa-solid fa-caret-right cursor-pointer"></i>
            <h3 class="ml-2">Chờ xác nhận (3)</h3>
          </li>
        </ul>
      </div>

      <div class="border-t-2">
        <button
          class="text-center block m-auto mt-4 text-white px-10 py-2 rounded-lg"
        >
          Hoàn tác
        </button>
      </div>
    </section>

    <section class="w-3/4">
      <div
        class="sticky w-full flex justify-between px-5 py-5 mt-1 bg-white rounded-xl"
      >
        <div class="flex items-center">
          <i class="fa-solid fa-receipt text-red-500 text-2xl"></i>
          <p class="mx-4 text-lg font-bold">Đơn hàng</p>
        </div>
        <label for="search" class="border-b-2 border-b-gray-400">
          <i class="fa-solid fa-magnifying-glass"></i>
          <input
            type="text"
            id="search"
            placeholder="Tìm kiếm sản phẩm"
            class="border-none focus:ring-0"
          />
        </label>
      </div>

      <div class="px-5 overflow-auto">
        <table class="w-full">
        <thead>
          <tr class="bg-gray-100 h-14">
            <th class="w-1/3 text-left pl-20">Thông tin đơn hàng</th>
            <th class="w-1/3 text-left pl-20">Mã đơn hàng</th>
            <th class="w-1/3 text-left pl-20">Trạng thái</th>
          </tr>
        </thead>
        <tbody>
          <tr class="border-b border-gray-200">
            <td class="py-3 flex items-center pl-20 mt-1">
              <img src="/images/product-demo.png" class="max-h-16" alt="" />
              <a href="" class="mx-2 underline">2022春夏新...</a>
              <span>x1</span>
            </td>
            <td class=" w-1/3 pl-20">MD001</td>
            <td class="w-1/3 pl-20 text-red-700 font-semibold">Chờ xác nhận</td>
          </tr>
          
          <tr class="w-full h-16 border-b border-gray-200">
            <td class="py-3 flex items-center pl-20 mt-1">
              <img src="/images/product-demo.png" class="max-h-16" alt="" />
              <a href="" class="mx-2 underline">2022春夏新...</a>
              <span>x1</span>
            </td>
            <td class="w-1/3 pl-20">MD001</td>
            <td class="w-1/3 pl-20 text-red-700 font-semibold">Chờ xác nhận</td>
          </tr>

          <tr class="w-full h-16 border-b border-gray-200">
            <td class="py-3 flex items-center pl-20 mt-1">
              <img src="/images/product-demo.png" class="max-h-16" alt="" />
              <a href="" class="mx-2 underline">2022春夏新...</a>
              <span>x1</span>
            </td>
            <td class="w-1/3 pl-20">MD001</td>
            <td class="w-1/3 pl-20 text-yellow-400 font-semibold">Đã nhận hàng</td>
          </tr>
          <tr class="w-full h-16 border-b border-gray-200">
            <td class="py-3 flex items-center pl-20 mt-1">
              <img src="/images/product-demo.png" class="max-h-16" alt="" />
              <a href="" class="mx-2 underline">2022春夏新...</a>
              <span>x1</span>
            </td>
            <td class="w-1/3 pl-20">MD001</td>
            <td class="w-1/3 pl-20 text-gray-500 font-semibold">Đã hủy</td>
          </tr>
        </tbody>
      </table>
      </div>
    </section>
  </section>
</template>

<script>
export default {};
</script>

<style scoped>
button {
  background-color: #ff3f3a;
}
::-webkit-scrollbar {
  width: 15px;
  height: 20px;
}

::-webkit-scrollbar-track {
  border-radius: 100vh;
  background: transparent;
}

::-webkit-scrollbar-thumb {
  background: #e0cbcb;
  border-radius: 100vh;
  border: 3px solid #f6f7ed;
}

::-webkit-scrollbar-thumb:hover {
  background: rgb(253, 114, 114);
}
</style>
